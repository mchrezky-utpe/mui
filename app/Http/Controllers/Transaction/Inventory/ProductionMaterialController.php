<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction\Inventory\TransProductionMaterialRequest;
use App\Models\Transaction\Inventory\TransStockIssue;
use App\Models\Transaction\Inventory\MstSku;
use App\Models\Master\Sku\SkuListVw;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
                'trans_production_material_request.created_at',
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

        if ($request->search && $request->search['value']) {
            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {
                $q->where('trans_production_material_request.ps_code', 'like', "%{$search}%")
                    ->orWhere('trans_production_material_request.pmr_code', 'like', "%{$search}%")
                    ->orWhere('sku.sku_id', 'like', "%{$search}%")
                    ->orWhere('sku.sku_name', 'like', "%{$search}%")
                    ->orWhere('sku.sku_material_type', 'like', "%{$search}%")
                    ->orWhere('sku.sku_inventory_unit', 'like', "%{$search}%")
                    ->orWhere('sku.sku_sales_category', 'like', "%{$search}%");
            });
        }

        $totalData = TransProductionMaterialRequest::count();

        $filteredQuery = clone $query;
        $recordsFiltered = $filteredQuery->count();

        $start  = $request->start ?? 0;
        $length = $request->length ?? 10;

        $data = $query
            ->orderBy('trans_production_material_request.created_at', 'desc')
            ->offset($start)
            ->limit($length)
            ->get();

        $data->transform(function ($item) {
            $item->stock_status = ($item->val_conversion >= $item->quantity_request)
                ? 'AVAILABLE'
                : 'NOT_AVAILABLE';
            return $item;
        });

        return response()->json([
            'draw'            => intval($request->draw),
            'recordsTotal'    => $totalData,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
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

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('trans_production_material_request.ps_code', 'like', "%{$search}%")
                    ->orWhere('trans_production_material_request.pmr_code', 'like', "%{$search}%")
                    ->orWhere('sku.sku_id', 'like', "%{$search}%")
                    ->orWhere('sku.sku_name', 'like', "%{$search}%")
                    ->orWhere('sku.sku_material_type', 'like', "%{$search}%")
                    ->orWhere('sku.sku_inventory_unit', 'like', "%{$search}%")
                    ->orWhere('sku.sku_sales_category', 'like', "%{$search}%");
            });
        }

        $updated = $query->update([
            'production_material_request_status' => $request->action,
            'updated_by' => Auth::id(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Successfully {$request->action} ({$updated} data)",
        ]);
    }

    public function api_droplist_stock_issue(Request $request)
    {
        $query = SkuListVw::query()
            ->select([
                'sku_id',
                'sku_name',
                'sku_specification_code',
                'sku_material_type',
                'sku_inventory_unit',
                'val_conversion',
                'sku_sub_category',
                'created_at',
            ]);


        if ($request->stock_issue_date) {
            $query->whereDate(
                'created_at',
                $request->stock_issue_date
            );
        }

        if ($request->stock_issue_type) {
            if ($request->stock_issue_type == 'General') {
                $query->where('sku_sub_category', 'GENERAL');
            } else if ($request->stock_issue_type == 'Anhilination') {
                $query->where('sku_material_type', 'like', '%NOT GOOD%');
            }
        }

        if ($request->search && $request->search['value']) {
            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {
                $q->where('sku_id', 'like', "%{$search}%")
                    ->orWhere('sku_name', 'like', "%{$search}%")
                    ->orWhere('sku_material_type', 'like', "%{$search}%")
                    ->orWhere('sku_inventory_unit', 'like', "%{$search}%")
                    ->orWhere('sku_sub_category', 'like', "%{$search}%")
                    ->orWhere('sku_specification_code', 'like', "%{$search}%");
            });
        }

        $totalData = SkuListVw::count();

        $filteredQuery = clone $query;
        $recordsFiltered = $filteredQuery->count();

        $start  = $request->start ?? 0;
        $length = $request->length ?? 10;

        $data = $query
            ->orderBy('created_at', 'desc')
            ->offset($start)
            ->limit($length)
            ->get();

        return response()->json([
            'draw'            => intval($request->draw),
            'recordsTotal'    => $totalData,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ]);
    }

    public function api_approve_stock_issue(Request $request)
    {
        $request->validate([
            'sku_id' => 'required',
            'qty'    => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            $sku = MstSku::where('manual_id', $request->sku_id)->lockForUpdate()->first();

            if (!$sku) {
                throw new \Exception('SKU not found');
            }

            if ($request->qty > $sku->val_conversion) {
                throw new \Exception('Qty exceeds available stock');
            }

            TransStockIssue::create([
                'si_code'    => 'SI-' . now()->format('YmdHis'),
                'sku_id'     => $sku->id,
                'qty_before' => $sku->val_conversion,
                'qty_change' => $request->qty,
                'qty_after'  => $sku->val_conversion - $request->qty,
                'created_by' => Auth::id(),
            ]);

            $sku->update([
                'val_conversion' => $sku->val_conversion - $request->qty,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Stock issue successfully processed',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
