<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction\Inventory\StockOpening;
use App\Models\Transaction\Inventory\TransSkuOpeningStock;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\Inventory\MstSku;
use Illuminate\Support\Facades\DB;

class StockOpeningController extends Controller
{

    public function index()
    {
        $data = [
            'title'   => 'stock_opening',
            'css'     => 'transaction/inventory/stock_opening/css',
            'content' => 'transaction/inventory/stock_opening/index',
            'script'  => 'transaction/inventory/stock_opening/script',
        ];

        return view('transaction/inventory/stock_opening/index', $data);
    }

    public function data(Request $request)
    {
        $q    = $request->input('q', '');
        $type = $request->input('type', 1);
        $date = $request->input('date', '');

        $views = [
            1 => 'transaction.inventory.stock_opening.part',
            2 => 'transaction.inventory.stock_opening.production',
            3 => 'transaction.inventory.stock_opening.general',
            4 => 'transaction.inventory.stock_opening.returnable',
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

    public function opening_stock(Request $request)
    {
        $sku_id = $request->sku_id;
        $qty    = $request->qty;

        DB::beginTransaction();

        try {

            //check mst_sku
            $sku = MstSku::where('id', $sku_id)->first();

            if (!$sku) {
                throw new \Exception('Item not found');
            }

            TransSkuOpeningStock::create([
                'sku_id'    => $sku->id,
                'qty'       => $qty,
                'trans_date' => date('Y-m-d'),
                'created_by' => Auth::id(),
            ]);

            MstSku::where('id', $sku->id)->update([
                'val_conversion' => $qty
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Opening stock success'
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
