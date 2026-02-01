<?php

namespace App\Http\Controllers\Transaction\Inventory;

use Illuminate\Http\Request;
use App\Models\MasterCustomer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\Inventory\CustomerReturn;
use App\Models\Transaction\Inventory\CustomerReturnDetail;
use App\Models\Transaction\Inventory\DeliveryOrder;
use App\Models\Transaction\Inventory\DeliveryOrderDetail;

class CustomerReturnController extends Controller
{

    public function index()
    {
        $customers = MasterCustomer::select('id', 'name')->get();
        $data = [
            'css'     => 'transaction/inventory/customer_return/css',
            'content' => 'transaction/inventory/customer_return/index',
            'script'  => 'transaction/inventory/customer_return/script',
            'customers'  => $customers,
        ];

        return view('transaction/inventory/customer_return/index', $data);
    }

    public function create()
    {
        $customers = MasterCustomer::select('id', 'name')->get();
        $data = [
            'css'     => 'transaction/inventory/customer_return/css',
            'content' => 'transaction/inventory/customer_return/index',
            'script'  => 'transaction/inventory/customer_return/script',
            'customers' => $customers,
        ];

        return view('transaction/inventory/customer_return/create', $data);
    }

    public function getAll(Request $request)
    {
        try {
            $draw   = $request->get('draw');
            $start  = $request->get('start');
            $length = $request->get('length');
            $search = $request->get('search')['value'];

            $query = CustomerReturn::from('trans_customer_return as a')
                ->leftJoin('mst_customer as b', 'b.id', '=', 'a.customer_id');

            $totalRecords = (clone $query)->count();

            if ($request->customerFilter) {
                $query->where('a.customer_id', $request->customerFilter);
            }
            if ($request->fromDateFilter) {
                $query->where('a.cr_date', '>=', $request->fromDateFilter);
            }
            if ($request->untilDateFilter) {
                $query->where('a.cr_date', '<=', $request->untilDateFilter);
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('a.cr_code', 'LIKE', '%' . $search . '%')
                        ->orWhere('a.cr_type', 'LIKE', '%' . $search . '%')
                        ->orWhere('a.return_do_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('b.name', 'LIKE', '%' . $search . '%');
                });
            }

            $totalRecordWithFilter = (clone $query)->count();

            $data = $query->selectRaw('a.id, a.cr_code, a.cr_date, a.cr_type, a.return_do_number, b.name as customer_name, a.cr_status')
                ->skip($start)
                ->take($length)
                ->get();

            foreach ($data as $d) {
                $d->details = CustomerReturnDetail::from('trans_customer_return_detail as a')
                    ->leftJoin('trans_delivery_order_detail as b', 'b.id', '=', 'a.delivery_order_detail_id')
                    ->leftJoin('vw_app_list_mst_sku as c', 'c.id', '=', 'b.sku_id')
                    ->leftJoin('trans_customer_delivery_schedule_details as d', function ($join) {
                        $join->on('d.id', '=', 'b.source_id')->where('b.source_type', '=', 'CDS');
                    })
                    ->leftJoin('trans_customer_delivery_schedule as e', 'e.id', '=', 'd.customer_delivery_schedule_id')
                    ->leftJoin('trans_sales_order_details as f', 'f.id', '=', 'd.sales_order_details_id')
                    ->leftJoin('trans_sales_order as g', 'g.id', '=', 'f.id_sales_order')
                    ->leftJoin('trans_delivery_order as h', 'h.id', '=', 'b.delivery_order_id')
                    ->where('a.customer_return_id', $d->id)
                    ->selectRaw('a.id, g.po_number, e.cds_code, h.do_number, c.sku_id, c.sku_name, c.sku_specification_code, c.sku_model, c.sku_inventory_unit, a.return_qty, a.outstanding_qty')
                    ->get();
            }

            return response()->json([
                'success' => true,
                'message' => "Get data customer return successfully",
                'data' => [
                    "draw"            => intval($draw),
                    "recordsTotal"    => $totalRecords,
                    "recordsFiltered" => $totalRecordWithFilter,
                    "data"            => $data
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Error Request, Exception Error!",
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllDetail(Request $request)
    {
        try {
            $draw   = $request->get('draw');
            $start  = $request->get('start');
            $length = $request->get('length');
            $search = $request->get('search')['value'];

            $query = CustomerReturnDetail::from('trans_customer_return_detail as a')
                ->leftJoin('trans_delivery_order_detail as b', 'b.id', '=', 'a.delivery_order_detail_id')
                ->leftJoin('vw_app_list_mst_sku as c', 'c.id', '=', 'b.sku_id')
                ->leftJoin('trans_customer_delivery_schedule_details as d', function ($join) {
                    $join->on('d.id', '=', 'b.source_id')->where('b.source_type', '=', 'CDS');
                })
                ->leftJoin('trans_customer_delivery_schedule as e', 'e.id', '=', 'd.customer_delivery_schedule_id')
                ->leftJoin('trans_sales_order_details as f', 'f.id', '=', 'd.sales_order_details_id')
                ->leftJoin('trans_sales_order as g', 'g.id', '=', 'f.id_sales_order')
                ->leftJoin('trans_delivery_order as h', 'h.id', '=', 'b.delivery_order_id')
                ->leftJoin('trans_customer_return as i', 'i.id', '=', 'a.customer_return_id');

            $totalRecords = (clone $query)->count();

            if ($request->customerFilterDetail) {
                $query->where('i.customer_id', $request->customerFilterDetail);
            }
            if ($request->fromDateFilterDetail) {
                $query->where('i.cr_date', '>=', $request->fromDateFilterDetail);
            }
            if ($request->untilDateFilterDetail) {
                $query->where('i.cr_date', '<=', $request->untilDateFilterDetail);
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('c.sku_id', 'LIKE', '%' . $search . '%')
                        ->orWhere('c.sku_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('c.sku_specification_code', 'LIKE', '%' . $search . '%')
                        ->orWhere('i.cr_code', 'LIKE', '%' . $search . '%')
                        ->orWhere('g.po_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('e.cds_code', 'LIKE', '%' . $search . '%')
                        ->orWhere('h.do_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('i.return_do_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('c.sku_model', 'LIKE', '%' . $search . '%')
                        ->orWhere('c.sku_inventory_unit', 'LIKE', '%' . $search . '%');
                });
            }

            $totalRecordWithFilter = (clone $query)->count();

            $data = $query->selectRaw('a.id, c.sku_id, c.sku_name, c.sku_specification_code, i.cr_code, g.po_number, e.cds_code, h.do_number, i.return_do_number, c.sku_model, c.sku_inventory_unit, a.return_qty, a.outstanding_qty, 0 as outstanding_qc_qty')
                ->skip($start)
                ->take($length)
                ->get();

            return response()->json([
                'success' => true,
                'message' => "Get data customer return detail successfully",
                'data' => [
                    "draw"            => intval($draw),
                    "recordsTotal"    => $totalRecords,
                    "recordsFiltered" => $totalRecordWithFilter,
                    "data"            => $data
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Error Request, Exception Error!",
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function getSourceData(Request $request)
    {
        try {
            if ($request->isShow == 'false') {
                return response()->json([
                    'success' => true,
                    'message' => "Get data delivery order successfully",
                    'data' => [
                        "draw"            => 1,
                        "recordsTotal"    => 0,
                        "recordsFiltered" => 0,
                        "data"            => []
                    ]
                ], 200);
            }

            $draw   = $request->get('draw');
            $start  = $request->get('start');
            $length = $request->get('length');
            $search = $request->get('search')['value'];

            $query = DeliveryOrderDetail::from('trans_delivery_order_detail as a')
                ->leftJoin('vw_app_list_mst_sku as b', 'b.id', '=', 'a.sku_id')
                ->leftJoin('trans_customer_delivery_schedule_details as c', function ($join) {
                    $join->on('c.id', '=', 'a.source_id')->where('a.source_type', '=', 'CDS');
                })
                ->leftJoin('trans_customer_delivery_schedule as d', 'd.id', '=', 'c.customer_delivery_schedule_id')
                ->leftJoin('trans_sales_order_details as e', 'e.id', '=', 'c.sales_order_details_id')
                ->leftJoin('trans_sales_order as f', 'f.id', '=', 'e.id_sales_order')
                ->leftJoin('trans_delivery_order as g', 'g.id', '=', 'a.delivery_order_id');

            $totalRecords = (clone $query)->count();

            $totalRecordWithFilter = (clone $query)->count();

            $data = $query->selectRaw('a.id, g.do_date, f.po_number, d.cds_code, g.do_number, b.sku_id, b.sku_name, b.sku_specification_code, b.sku_business_type, b.sku_model, a.qty')
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
                'success' => false,
                'message' => "Error Request, Exception Error!",
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function getSourceDataDetail(Request $request)
    {
        try {
            $data = DeliveryOrderDetail::from('trans_delivery_order_detail as a')
                ->leftJoin('vw_app_list_mst_sku as b', 'b.id', '=', 'a.sku_id')
                ->leftJoin('trans_customer_delivery_schedule_details as c', function ($join) {
                    $join->on('c.id', '=', 'a.source_id')->where('a.source_type', '=', 'CDS');
                })
                ->leftJoin('trans_customer_delivery_schedule as d', 'd.id', '=', 'c.customer_delivery_schedule_id')
                ->leftJoin('trans_sales_order_details as e', 'e.id', '=', 'c.sales_order_details_id')
                ->leftJoin('trans_sales_order as f', 'f.id', '=', 'e.id_sales_order')
                ->leftJoin('trans_delivery_order as g', 'g.id', '=', 'a.delivery_order_id')
                ->where('a.id', $request->id)
                ->selectRaw('a.id, g.do_date, f.po_number, d.cds_code, g.do_number, b.sku_id, b.sku_name, b.sku_specification_code, b.sku_business_type, b.sku_model, a.qty, b.sku_inventory_unit')
                ->first();

            return response()->json([
                'success' => true,
                'message' => "Get source data detail successfully",
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Error Request, Exception Error!",
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function createCR(Request $request)
    {
        DB::beginTransaction();

        try {
            $maxSeqNumber = CustomerReturn::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->max('cr_code_seq');
            $crCode = $this->generateCRCode($maxSeqNumber + 1);

            // Insert Customer Return
            $customerReturn = CustomerReturn::create([
                'cr_code' => $crCode,
                'cr_code_seq' => $maxSeqNumber + 1,
                'cr_date' => $request->crDate,
                'cr_type' => $request->crType,
                'customer_id' => $request->customer,
                'return_do_number' => $request->returnDONumber,
                'cr_status' => 'DONE',
                'created_by' => Auth::id(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Insert Customer Return Detail
            $seqNumberDetail = 1;
            foreach ($request->listItem as $item) {
                $crCodeDetail = $this->generateCRCodeDetail($crCode, $seqNumberDetail);
                $customerReturnDetail = CustomerReturnDetail::create([
                    'crd_code' => $crCodeDetail,
                    'crd_code_seq' => $seqNumberDetail,
                    'customer_return_id' => $customerReturn->id,
                    'delivery_order_detail_id' => (int)$item['id'],
                    'return_qty' => floatval($item['qty']),
                    'outstanding_qty' => floatval($item['qty']),
                    'created_by' => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $deliveryDetail = DeliveryOrderDetail::where('id', (int)$item['id'])->select('delivery_order_id')->first();
                // Update Delivery Order
                $deliveryDetail = DeliveryOrder::where('id', $deliveryDetail->delivery_order_id)->update([
                    'is_returned' => 1,
                    'return_date' => date('Y-m-d'),
                    'updated_by' => Auth::id(),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $seqNumberDetail++;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Create customer return successfully",
                'data' => $customerReturn
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Error Request, Exception Error!",
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function generateCRCode($seqNumber)
    {
        $paddedSequence = str_pad($seqNumber, 4, '0', STR_PAD_LEFT);
        $year = date('y');
        $month = date('m');

        return "CR-{$year}/{$month}/{$paddedSequence}";
    }

    public function generateCRCodeDetail($crCode, $seqNumber)
    {
        $paddedSequence = str_pad($seqNumber, 3, '0', STR_PAD_LEFT);

        return "CRD-{$crCode}-{$paddedSequence}";
    }
}
