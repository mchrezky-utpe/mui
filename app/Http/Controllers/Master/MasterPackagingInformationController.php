<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterPackagingInformationController
{
    public function index()
    {
        try {
            $packagingCategory = DB::table('vw_app_list_mst_packaging_infromation_category')->select('id', 'description')->get();
            $packagingPartition = DB::table('vw_app_list_mst_packaging_infromation_partition')->select('id', 'description')->get();

            $data = [
                'packagingCategory' => $packagingCategory,
                'packagingPartition' => $packagingPartition,
            ];
            return view('master.packaging_information.index', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Request, Exception Error!');
        }
    }

    public function getData(Request $request)
    {
        try {
            $draw   = $request->get('draw');
            $start  = $request->get('start');
            $length = $request->get('length');
            $search = $request->get('search')['value'];

            $query = DB::table('vw_app_list_mst_sku as a')
                ->leftJoin('mst_sku as b', 'a.id', '=', 'b.id')
                ->leftJoin('vw_app_list_mst_packaging_infromation_category as c', 'b.sku_packaging_category_id', '=', 'c.id')
                ->leftJoin('vw_app_list_mst_packaging_infromation_partition as d', 'b.sku_packaging_partition_id', '=', 'd.id')
                ->where('sku_type', 'Part');

            $totalRecords = (clone $query)->count();

            $totalRecordWithFilter = (clone $query)->count();

            $data = $query->selectRaw('a.id, a.sku_id, a.sku_name, b.sku_packaging_category_id, b.sku_packaging_partition_id, b.qty_per_partition, c.prefix as pck_code, c.sub_category, c.type, c.description, c.model, c.category_size, c.unit, c.total_stock, d.sub_category as partition_sub_category, d.type as partition_type, d.description as partition_description, d.size as partition_size, d.capacity as partition_capacity')
                ->skip($start)
                ->take($length)
                ->get();

            return response()->json([
                'success' => true,
                'message' => "Get data delivery order successfully",
                'data' => [
                    "draw"            => intval($draw),
                    "recordsTotal"    => $totalRecords,
                    "recordsFiltered" => $totalRecordWithFilter,
                    "data"            => $data
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error Request, Exception Error!' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::table('mst_sku')
                ->where('id', $id)
                ->update([
                    'sku_packaging_category_id' => $request->packaging_category_id,
                    'sku_packaging_partition_id' => $request->packaging_partition_id,
                    'qty_per_partition' => floatval($request->qty_per_partition),
                    'updated_by' => auth()->user()->name,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            return response()->json([
                'success' => true,
                'message' => "Update packaging information successfully",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error Request, Exception Error!' . $e->getMessage(),
            ], 500);
        }
    }
}
