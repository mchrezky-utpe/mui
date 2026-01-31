<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction\Sales\TransSalesOrderDetails;
use App\Models\MasterCustomerDeliveryDestination;
use App\Models\Transaction\Inventory\TransCustomerDeliverySchedule;
use App\Models\Transaction\Inventory\TransCustomerDeliveryScheduleDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\Inventory\MstSku;

class CustomerDeliveryScheduleController extends Controller
{

    public function index()
    {
        $data = [
            'css'     => 'transaction/inventory/customer_delivery_schedule/css',
            'content' => 'transaction/inventory/customer_delivery_schedule/index',
            'script'  => 'transaction/inventory/customer_delivery_schedule/script',
        ];

        return view('transaction/inventory/customer_delivery_schedule/index', $data);
    }

    public function api_droplist_sales_order_list(Request $request)
    {
        $query = TransSalesOrderDetails::query()
            ->join('vw_app_list_mst_sku', 'trans_sales_order_details.sku_id', '=', 'vw_app_list_mst_sku.id')
            ->join('trans_sales_order', 'trans_sales_order_details.id_sales_order', '=', 'trans_sales_order.id')
            ->select([
                'trans_sales_order_details.*',
                'trans_sales_order.so_number as so_number',
                'trans_sales_order.po_number as po_number',
                'trans_sales_order.validation_status as validation_status',
                'trans_sales_order.valid_from as valid_from',
                'trans_sales_order.valid_until as valid_until',
                'vw_app_list_mst_sku.sku_id as sku_id',
                'vw_app_list_mst_sku.sku_name as sku_name',
                'vw_app_list_mst_sku.sku_specification_code as sku_specification_code',
                'vw_app_list_mst_sku.sku_inventory_unit as sku_inventory_unit',
            ]);

        if ($request->filled('po_number')) {
            $query->where('trans_sales_order.po_number', $request->po_number);
        }

        if ($request->filled('customer')) {
            $query->where('trans_sales_order.customer_id', $request->customer);
        }

        if ($request->filled('valid_from') && $request->filled('valid_until')) {
            $query->where(function ($q) use ($request) {
                $q->whereDate('trans_sales_order.valid_from', '<=', $request->valid_until)
                    ->whereDate('trans_sales_order.valid_until', '>=', $request->valid_from);
            });
        }

        if (!empty($request->search['value'])) {
            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {
                $q->where('vw_app_list_mst_sku.sku_id', 'like', "%{$search}%")
                    ->orWhere('vw_app_list_mst_sku.sku_name', 'like', "%{$search}%")
                    ->orWhere('vw_app_list_mst_sku.sku_specification_code', 'like', "%{$search}%")
                    ->orWhere('vw_app_list_mst_sku.sku_inventory_unit', 'like', "%{$search}%")
                    ->orWhere('trans_sales_order.so_number', 'like', "%{$search}%")
                    ->orWhere('trans_sales_order.po_number', 'like', "%{$search}%");
            });
        }


        $totalData = TransSalesOrderDetails::where(
            'id_sales_order',
            $request->sales_order_id
        )->count();

        $recordsFiltered = (clone $query)->count();

        $data = $query
            ->orderBy('trans_sales_order_details.id', 'desc')
            ->offset($request->start ?? 0)
            ->limit($request->length ?? 10)
            ->get();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    public function api_droplist_list_customer_destination(Request $request)
    {
        $data = MasterCustomerDeliveryDestination::where('customer_id', $request->customer_id)->where('flag_active', 1)->get();

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    private function generateCdsNumber()
    {
        $year = now()->format('y');
        $month = now()->format('m');

        $last = TransCustomerDeliverySchedule::whereYear('cds_date', now()->year)
            ->whereMonth('cds_date', now()->month)
            ->max('cds_code_seq');

        $seq = ($last ?? 0) + 1;

        return [
            'seq' => $seq,
            'number' => sprintf("CDS-%s/%s/%04d", $year, $month, $seq)
        ];
    }

    private function generateCdsdNumber($cdsNumber, $seq)
    {
        return sprintf("CDSD-%s-%03d", $cdsNumber, $seq);
    }

    public function api_insert_customer_delivery_schedule(Request $request)
    {
        DB::beginTransaction();

        try {
            $cdsNumberData = $this->generateCdsNumber();

            $cds = TransCustomerDeliverySchedule::create([
                'cds_code'        => $cdsNumberData['number'],
                'cds_code_seq'    => $cdsNumberData['seq'],
                'cds_date'        => now()->toDateString(),
                'customer_delivery_number' => $request->po_number,
                'customer_id'     => $request->customer_id,
                'valid_from'      => $request->valid_from,
                'valid_until'     => $request->valid_until,
                'validation_status' => 'UP TO DATE',
                'cds_status'      => 1,
                'created_by'      => Auth::id(),
            ]);

            $seq = 1;
            foreach ($request->items as $item) {
                $sku = MstSku::where('manual_id', $item['sku_id'])->first();

                TransCustomerDeliveryScheduleDetails::create([
                    'cdsd_code'                    => $this->generateCdsdNumber($cdsNumberData['number'], $seq),
                    'cdsd_code_seq'                => $seq,
                    'customer_delivery_schedule_id' => $cds->id,
                    'delivery_plan_date'           => $item['delivery_plan_date'],
                    'sku_id'                       => $sku->id ?? null,
                    'customer_delivery_destination_id' => $item['destination_code'],
                    'sales_order_details_id'       => $item['id'],
                    'quantity_cds'                 => $item['quantity_order'],
                    'outstanding'                  => $item['quantity_order'],
                    'valid_from'                   => $request->valid_from,
                    'valid_until'                  => $request->valid_until,
                    'validation_status'            => 'UP TO DATE',
                    'delivery_status'              => 'PENDING',
                    'created_by'                   => Auth::id(),
                ]);

                $seq++;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Customer Delivery Schedule berhasil disimpan',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
