<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction\Inventory\StockOpening;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\Inventory\MstSku;
use App\Models\Transaction\SkuMinOfStock;
use Illuminate\Support\Facades\DB;

class MinimumStockController extends Controller
{

    public function index()
    {
        $data = [
            'title'   => 'minimum_stock',
            'css'     => 'transaction/inventory/minimum_stock/css',
            'content' => 'transaction/inventory/minimum_stock/index',
            'script'  => 'transaction/inventory/minimum_stock/script',
        ];

        return view('transaction/inventory/minimum_stock/index', $data);
    }

    public function data(Request $request)
    {
        $q    = $request->input('q', '');
        $type = $request->input('type', 1);

        $views = [
            1 => 'transaction.inventory.minimum_stock.part',
            2 => 'transaction.inventory.minimum_stock.production',
            3 => 'transaction.inventory.minimum_stock.general',
            4 => 'transaction.inventory.minimum_stock.returnable',
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
                ->where('flag_sku_type', $type)
                ->where('flag_inventory_register', 1)
                ->paginate(10);
        }

        $view = $views[$type] ?? $views[1];

        return view($view, compact('data', 'q', 'type'));
    }

    public function minimum_stock(Request $request)
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

            SkuMinOfStock::create([
                'sku_id'    => $sku->id,
                'qty'       => $qty,
                'flag_active' => 1,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
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
