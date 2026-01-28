<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction\Inventory\TransProductionMaterialRequest;

class ProductionMaterialController extends Controller
{

    public function index()
    {
        $data = [
            'css'     => 'transaction/inventory/production_material/css',
            'content' => 'transaction/inventory/production_material/index',
            'script'  => 'transaction/inventory/production_material/script',
        ];

        return view('transaction/inventory/production_material/index', $data);
    }

    public function api_droplist(Request $request)
    {
        $query = TransProductionMaterialRequest::query()
            ->leftJoin('vw_app_list_mst_sku as sku', 'sku.id', '=', 'trans_production_material_request.sku_id')
            ->select([
                'trans_production_material_request.ps_code',
                'sku.sku_sales_category',
                'trans_production_material_request.request_date',
                'trans_production_material_request.pmr_code',
                'sku.sku_id',
                'sku.sku_name',
                'sku.sku_material_type',
                'sku.sku_inventory_unit',
                'trans_production_material_request.quantity_request',
                'sku.val_conversion',
                'trans_production_material_request.production_material_request_status',
            ]);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween(
                'trans_production_material_request.request_date',
                [$request->start_date, $request->end_date]
            );
        }

        if ($request->process_type) {
            $query->where('sku.sku_sales_category', $request->process_type);
        }


        $data = $query->orderBy('trans_production_material_request.created_at', 'desc')->get();

        $data->transform(function ($item) {
            $item->stock_status = ($item->val_conversion >= $item->quantity_request)
                ? 'AVAILABLE'
                : 'NOT_AVAILABLE';
            return $item;
        });

        return response()->json([
            'data' => $data
        ]);
    }

    public function api_approve(Request $request)
    {
        $request->validate([
            'action' => 'required|in:APPROVED,REJECTED',
        ]);

        $query = TransProductionMaterialRequest::query()
            ->leftJoin(
                'vw_app_list_mst_sku as sku',
                'sku.id',
                '=',
                'trans_production_material_request.sku_id'
            );

        if ($request->start_date && $request->end_date) {
            $query->whereBetween(
                'trans_production_material_request.request_date',
                [$request->start_date, $request->end_date]
            );
        }

        if ($request->process_type) {
            $query->where(
                'sku.sku_sales_category',
                $request->process_type
            );
        }

        $updated = $query->update([
            'production_material_request_status' => $request->action,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Successfully {$request->action} ({$updated} data)",
        ]);
    }
}
