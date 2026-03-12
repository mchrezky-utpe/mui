<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction\Inventory\StockOpening;
use App\Models\Transaction\Inventory\TransSkuAdjusment;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\Inventory\MstSku;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StockAdjusmentController extends Controller
{

    public function index()
    {
        $data = [
            'title'   => 'stock_adjusment',
            'css'     => 'transaction/inventory/stock_adjusment/css',
            'content' => 'transaction/inventory/stock_adjusment/index',
            'script'  => 'transaction/inventory/stock_adjusment/script',
        ];

        return view('transaction/inventory/stock_adjusment/index', $data);
    }

    public function data(Request $request)
    {
        $q    = $request->input('q', '');
        $type = $request->input('type', 1);
        $date = $request->input('date', '');

        $views = [
            1 => 'transaction.inventory.stock_adjusment.part',
            2 => 'transaction.inventory.stock_adjusment.production',
            3 => 'transaction.inventory.stock_adjusment.general',
            4 => 'transaction.inventory.stock_adjusment.returnable',
        ];

        if ($type == 4) {

            $data = StockOpening::returnablePackagingView()
                ->when($q, function ($query, $q) {
                    $query->where('s.manual_id', 'like', "%$q%");
                })
                ->paginate(10);
        } else {

            $data = StockOpening::query()
                ->when($q, function ($query, $q) {
                    $query->where(function ($sub) use ($q) {
                        $sub->where('sku_id', 'like', "%$q%")
                            ->orWhere('sku_name', 'like', "%$q%")
                            ->orWhere('sku_specification_code', 'like', "%$q%")
                            ->orWhere('sku_material_type', 'like', "%$q%")
                            ->orWhere('sku_model', 'like', "%$q%")
                            ->orWhere('sku_inventory_unit', 'like', "%$q%");
                    });
                })
                ->when($date, function ($query, $date) {
                    $query->whereDate('created_at', $date);
                })
                ->where('flag_sku_type', $type)
                ->where('flag_inventory_register', 1)
                ->paginate(10);
        }

        $view = $views[$type] ?? $views[1];

        return view($view, compact('data', 'q', 'type', 'date'));
    }

    public function adjusment_stock(Request $request)
    {
        $sku_id = $request->sku_id;
        $qty    = $request->qty;

        DB::beginTransaction();

        try {

            $sku = MstSku::where('id', $sku_id)->first();

            if (!$sku) {
                throw new \Exception('Item not found');
            }

            $currentStock = $sku->val_conversion;

            // hitung stok baru
            $newStock = $currentStock + $qty;

            // tidak boleh minus
            if ($newStock < 0) {
                throw new \Exception('Stock cannot be less than 0');
            }

            TransSkuAdjusment::create([
                'sku_id'     => $sku->id,
                'qty'        => $qty,
                'trans_date' => date('Y-m-d'),
                'created_by' => Auth::id(),
            ]);

            MstSku::where('id', $sku->id)->update([
                'val_conversion' => $newStock
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Adjusment stock success'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function import_adjusment_stock(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json([
                'status' => false,
                'message' => 'File not found'
            ], 400);
        }

        DB::beginTransaction();

        try {

            $file = $request->file('file');
            $rows = Excel::toArray([], $file)[0];

            $errors = [];
            $successCount = 0;

            foreach ($rows as $index => $row) {

                if ($index == 0) continue;

                $partCode = trim($row[1] ?? '');
                $qtyRaw   = $row[2] ?? null;

                if (!$partCode) {
                    $errors[] = "Row " . ($index + 1) . " Part Code empty";
                    continue;
                }

                // validasi qty harus angka
                if (!is_numeric($qtyRaw)) {
                    $errors[] = "Row " . ($index + 1) . " Qty invalid format";
                    continue;
                }

                $qty = (int)$qtyRaw;

                $sku = MstSku::where('manual_id', $partCode)->first();

                if (!$sku) {
                    $errors[] = "Row " . ($index + 1) . " Part Code {$partCode} not found";
                    continue;
                }

                $currentStock = $sku->val_conversion ?? 0;
                $newStock = $currentStock + $qty;

                // tidak boleh minus
                if ($newStock < 0) {
                    $errors[] = "Row " . ($index + 1) . " Stock cannot be negative. Current stock {$currentStock}, adjustment {$qty}";
                    continue;
                }

                TransSkuAdjusment::create([
                    'sku_id'     => $sku->id,
                    'qty'        => $qty,
                    'trans_date' => date('Y-m-d'),
                    'created_by' => Auth::id(),
                ]);

                $sku->update([
                    'val_conversion' => $newStock
                ]);

                $successCount++;
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => "Import success. {$successCount} data inserted.",
                'errors'  => $errors
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
