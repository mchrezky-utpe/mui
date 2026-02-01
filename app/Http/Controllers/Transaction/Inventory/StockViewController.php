<?php

namespace App\Http\Controllers\Transaction\Inventory;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Master\Sku\SkuListVw;

class StockViewController extends Controller
{

    public function index()
    {
        $data = [
            'css'     => 'transaction/inventory/stock_view/css',
            'content' => 'transaction/inventory/stock_view/index',
            'script'  => 'transaction/inventory/stock_view/script',
        ];

        return view('transaction/inventory/stock_view/index', $data);
    }

    public function getAll(Request $request)
    {
        try {
            $draw   = $request->get('draw');
            $start  = $request->get('start');
            $length = $request->get('length');
            $search = $request->get('search')['value'];

            if ($request->type !== 'Returnable Packaging') {
                $query = SkuListVw::where('flag_inventory_register', 1);

                if ($request->type) {
                    $query->where('sku_type', $request->type);
                }

                $totalRecords = $query->count();

                if (!empty($search)) {
                    $query->where(function ($q) use ($search) {
                        $q->where('sku_id', 'LIKE', "%$search%")
                            ->orWhere('sku_name', 'LIKE', "%$search%")
                            ->orWhere('sku_specification_code', 'LIKE', "%$search%")
                            ->orWhere('sku_material_type', 'LIKE', "%$search%")
                            ->orWhere('sku_classification', 'LIKE', "%$search%")
                            ->orWhere('sku_sales_category', 'LIKE', "%$search%")
                            ->orWhere('sku_inventory_unit', 'LIKE', "%$search%");
                    });
                }

                $totalRecordWithFilter = $query->count();

                $data = $query->skip($start)
                    ->take($length)
                    ->get();
            } else {
                $query = DB::table('mst_packaging_information_category as a')
                    ->leftJoin('mst_sku_type as b', 'b.id', '=', 'a.type_id')
                    ->leftJoin('mst_sku_model as c', 'c.id', '=', 'a.model_id')
                    ->leftJoin('mst_sku_unit as d', 'd.id', '=', 'a.unit_id');

                $totalRecords = (clone $query)->count();

                if (!empty($search)) {
                    $query->where('a.description', 'LIKE', "%{$search}%");
                }

                $totalRecordWithFilter = (clone $query)->count();

                $data = $query->select('a.id', 'a.description', 'a.category_size', 'b.description as type', 'c.description as model', 'd.description as unit', 'a.total_stock')
                    ->skip($start)
                    ->take($length)
                    ->get();
            }

            return response()->json([
                'success' => true,
                'message' => "Get data stock view successfully",
                'data' => [
                    "draw"            => intval($draw),
                    "recordsTotal"    => $totalRecords,
                    "recordsFiltered" => $totalRecordWithFilter,
                    "data"            => $data
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => true,
                'message' => "Error Request, Exception Error!",
                'data' => $e->message
            ], 500);
        }
    }
}
