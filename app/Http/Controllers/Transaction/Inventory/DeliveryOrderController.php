<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Master\PackagingInformation\PackagingInformationCategory;
use App\Models\Master\PackagingInformation\PackagingInformationPartition;
use App\Models\Master\Sku\SkuListVw;
use App\Models\MasterCustomer;
use App\Models\MasterCustomerDeliveryDestination;
use App\Models\MasterDriver;
use App\Models\MasterSku;
use App\Models\MasterVehicle;
use App\Models\Transaction\Inventory\CustomerReturnDetail;
use App\Models\Transaction\Inventory\DeliveryOrder;
use App\Models\Transaction\Inventory\DeliveryOrderDetail;
use App\Models\Transaction\Inventory\TransCustomerDeliverySchedule;
use App\Models\Transaction\Inventory\TransCustomerDeliveryScheduleDetails;
use App\Models\Transaction\Sales\TransSalesInvoiceDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeliveryOrderController extends Controller
{

    public function index()
    {
        $customers = MasterCustomer::select('id', 'name')->get();
        $data = [
            'css'     => 'transaction/inventory/delivery_order/css',
            'content' => 'transaction/inventory/delivery_order/index',
            'script'  => 'transaction/inventory/delivery_order/script',
            'customers'  => $customers,
        ];

        return view('transaction/inventory/delivery_order/index', $data);
    }

    public function create()
    {
        try {
            $customer = MasterCustomer::select('id', 'name')->orderBy('name', 'asc')->get();
            $drivers = MasterDriver::select('id', 'driver_name')->orderBy('driver_name', 'asc')->get();
            $vehicles = MasterVehicle::select('id', 'license_plate')->get();

            $data = [
                'css'       => 'transaction/inventory/delivery_order/css',
                'content'   => 'transaction/inventory/delivery_order/index',
                'script'    => 'transaction/inventory/delivery_order/script',
                'customer'  => $customer,
                'drivers'   => $drivers,
                'vehicles'  => $vehicles
            ];

            return view('transaction/inventory/delivery_order/create', $data);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error Request, Exception Error!');
        }
    }

    public function getAll(Request $request)
    {
        try {
            $draw   = $request->get('draw');
            $start  = $request->get('start');
            $length = $request->get('length');
            $search = $request->get('search')['value'];

            $query = DeliveryOrder::from('trans_delivery_order as a')
                ->leftJoin('mst_customer as b', function ($join) {
                    $join->on('b.id', '=', 'a.customer_id')->where('a.do_destination_type', '=', 'Customer');
                })->leftJoin('mst_person_supplier as c', function ($join) {
                    $join->on('b.id', '=', 'a.supplier_id')->where('a.do_destination_type', '=', 'Supplier');
                })->leftJoin('mst_user as d', 'd.id', '=', 'a.do_officer_id')->whereNull('a.deleted_at');

            $totalRecords = (clone $query)->count();

            if ($request->doTypeFilter) {
                $query->where('a.do_type', $request->doTypeFilter);
            }
            if ($request->customerFilter) {
                $query->where('a.customer_id', $request->customerFilter);
            }
            if ($request->fromDateFilter) {
                $query->where('a.do_date', '>=', $request->fromDateFilter);
            }
            if ($request->untilDateFilter) {
                $query->where('a.do_date', '<=', $request->untilDateFilter);
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('a.do_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('a.do_type', 'LIKE', '%' . $search . '%')
                        ->orWhere('a.do_sub_type', 'LIKE', '%' . $search . '%')
                        ->orWhere('b.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('c.description', 'LIKE', '%' . $search . '%');
                });
            }

            $totalRecordWithFilter = (clone $query)->count();

            $data = $query->select('a.*', 'b.name as customer_name', 'c.description as supplier_name', 'd.name as do_officer_name')
                ->skip($start)
                ->take($length)
                ->get();

            foreach ($data as $d) {
                $d->details = DeliveryOrderDetail::from('trans_delivery_order_detail as a')
                    ->leftJoin('vw_app_list_mst_sku as b', 'b.id', '=', 'a.sku_id')
                    ->leftJoin('trans_customer_delivery_schedule_details as c', function ($join) {
                        $join->on('c.id', '=', 'a.source_id')->where('a.source_type', '=', 'CDS');
                    })
                    ->leftJoin('trans_customer_delivery_schedule as d', 'd.id', '=', 'c.customer_delivery_schedule_id')
                    ->leftJoin('trans_sales_order_details as e', 'e.id', '=', 'c.sales_order_details_id')
                    ->leftJoin('trans_sales_order as f', 'f.id', '=', 'e.id_sales_order')
                    ->leftJoin('trans_customer_return_detail as cc', function ($join) {
                        $join->on('cc.id', '=', 'a.source_id')->where('a.source_type', '=', 'CR');
                    })
                    ->leftJoin('trans_customer_return as dd', 'dd.id', '=', 'cc.customer_return_id')
                    ->leftJoin('trans_delivery_order_detail as ee', 'ee.id', '=', 'cc.delivery_order_detail_id')
                    ->leftJoin('trans_customer_delivery_schedule_details as ff', function ($join) {
                        $join->on('ff.id', '=', 'ee.source_id')->where('ee.source_type', '=', 'CDS');
                    })
                    ->leftJoin('trans_sales_order_details as gg', 'gg.id', '=', 'ff.sales_order_details_id')
                    ->leftJoin('trans_sales_order as hh', 'hh.id', '=', 'gg.id_sales_order')
                    ->leftJoin('trans_customer_delivery_schedule as ii', 'ii.id', '=', 'ff.customer_delivery_schedule_id')
                    ->where('a.delivery_order_id', $d->id)
                    ->selectRaw('f.po_number, hh.po_number as po_number_cr, d.customer_delivery_number, ii.customer_delivery_number as customer_delivery_number_cr, a.source_type, b.sku_id, b.sku_name, b.sku_specification_code, b.sku_business_type, b.sku_model, b.sku_inventory_unit, b.val_conversion, a.qty, c.quantity_cds, c.outstanding, dd.return_do_number, cc.outstanding_qty as outstanding_cr_qty')
                    ->get();
            }

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

    public function getAllDetail(Request $request)
    {
        try {
            $draw   = $request->get('draw');
            $start  = $request->get('start');
            $length = $request->get('length');
            $search = $request->get('search')['value'];

            $query = DeliveryOrderDetail::from('trans_delivery_order_detail as a')
                ->leftJoin('trans_delivery_order as b', 'b.id', '=', 'a.delivery_order_id')
                ->leftJoin('trans_customer_delivery_schedule_details as c', function ($join) {
                    $join->on('c.id', '=', 'a.source_id')->where('a.source_type', '=', 'CDS');
                })->leftJoin('trans_customer_delivery_schedule as d', 'd.id', '=', 'c.customer_delivery_schedule_id')
                ->leftJoin('trans_sales_order_details as e', 'e.id', '=', 'c.sales_order_details_id')
                ->leftJoin('trans_sales_order as f', 'f.id', '=', 'e.id_sales_order')
                ->leftJoin('vw_app_list_mst_sku as g', 'g.id', '=', 'a.sku_id')
                ->leftJoin('mst_customer as h', function ($join) {
                    $join->on('h.id', '=', 'b.customer_id')->where('b.do_destination_type', '=', 'Customer');
                })->leftJoin('mst_person_supplier as i', function ($join) {
                    $join->on('i.id', '=', 'b.supplier_id')->where('b.do_destination_type', '=', 'Supplier');
                })->whereNull('b.deleted_at');

            $totalRecords = (clone $query)->count();

            if ($request->doTypeFilterDetail) {
                $query->where('b.do_type', $request->doTypeFilterDetail);
            }
            if ($request->customerFilterDetail) {
                $query->where('b.customer_id', $request->customerFilterDetail);
            }
            if ($request->fromDateFilterDetail) {
                $query->where('b.do_date', '>=', $request->fromDateFilterDetail);
            }
            if ($request->untilDateFilterDetail) {
                $query->where('b.do_date', '<=', $request->untilDateFilterDetail);
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('b.do_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('f.po_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('d.customer_delivery_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('h.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('i.description', 'LIKE', '%' . $search . '%')
                        ->orWhere('g.sku_id', 'LIKE', '%' . $search . '%')
                        ->orWhere('g.sku_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('g.sku_specification_code', 'LIKE', '%' . $search . '%')
                        ->orWhere('g.sku_material_type', 'LIKE', '%' . $search . '%')
                        ->orWhere('g.sku_inventory_unit', 'LIKE', '%' . $search . '%');
                });
            }

            $totalRecordWithFilter = (clone $query)->count();

            $data = $query->selectRaw('b.do_date, b.do_number, b.do_destination_type, f.po_number, d.customer_delivery_number, h.name as customer_name, i.description as supplier_name, g.sku_id, g.sku_name, g.sku_specification_code, g.sku_material_type, g.sku_inventory_unit, g.val_conversion, a.source_type, a.qty, c.quantity_cds, c.outstanding')
                ->skip($start)
                ->take($length)
                ->get();

            return response()->json([
                'success' => true,
                'message' => "Get data delivery order detail successfully",
                'data' => [
                    "draw"            => intval($draw),
                    "recordsTotal"    => $totalRecords,
                    "recordsFiltered" => $totalRecordWithFilter,
                    "data"            => $data
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'message' => "Error Request, Exception Error!",
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function getDestination(Request $request)
    {
        try {
            if ($request->type == 'select') {
                $data = MasterCustomerDeliveryDestination::select('id', 'destination_name')
                    ->where('customer_id', $request->customerId)->get();
            } else {
                $data = MasterCustomerDeliveryDestination::where('id', $request->id)->first();
            }

            return response()->json([
                'success' => true,
                'message' => "Get data destination successfully",
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Error Request, Exception Error!",
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function getDeliverySource(Request $request)
    {
        try {
            if ($request->doType == 'Sample Part') {
                $data = SkuListVw::where('flag_inventory_register', 1)
                    ->where('is_has_opening', 1)
                    ->where(function ($q) use ($request) {
                        if ($request->subDoType) {
                            $q->where('sku_type', $request->subDoType);
                        }
                    })
                    ->selectRaw('id, NULL as delivery_date, NULL as po_number, NULL as cds_code, NULL as cd_number, sku_id, sku_name, sku_specification_code, sku_business_type, sku_model, val_conversion')
                    ->get();
            } else if ($request->doType == 'Regular') {
                $data = TransCustomerDeliveryScheduleDetails::from('trans_customer_delivery_schedule_details as a')
                    ->leftJoin('trans_customer_delivery_schedule as b', 'b.id', '=', 'a.customer_delivery_schedule_id')
                    ->leftJoin('vw_app_list_mst_sku as c', 'c.id', '=', 'a.sku_id')
                    ->leftJoin('trans_sales_order_details as d', 'd.id', '=', 'a.sales_order_details_id')
                    ->leftJoin('trans_sales_order as e', 'e.id', '=', 'd.id_sales_order')
                    ->where(function ($q) use ($request) {
                        if ($request->subDoType) {
                            $q->where('c.sku_type', $request->subDoType);
                        }
                        if ($request->customerId) {
                            $q->where('b.customer_id', $request->customerId);
                        }
                        if ($request->deliveryDestinationId) {
                            $q->where('a.customer_delivery_destination_id', $request->deliveryDestinationId);
                        }
                    })
                    ->where('a.outstanding', '>', 0)
                    ->selectRaw('a.id, a.delivery_plan_date as delivery_date, e.po_number, b.cds_code, b.customer_delivery_number as cd_number, c.sku_id, c.sku_name, c.sku_specification_code, c.sku_business_type, c.sku_model, a.quantity_cds, a.outstanding')
                    ->get();
            } else if ($request->doType == 'Replacement') {
                $data = CustomerReturnDetail::from('trans_customer_return_detail as a')
                    ->leftJoin('trans_delivery_order_detail as b', 'b.id', '=', 'a.delivery_order_detail_id')
                    ->leftJoin('trans_customer_delivery_schedule_details as c', function ($join) {
                        $join->on('c.id', '=', 'b.source_id')->where('b.source_type', 'CDS');
                    })->leftJoin('trans_customer_delivery_schedule as d', 'd.id', '=', 'c.customer_delivery_schedule_id')
                    ->leftJoin('vw_app_list_mst_sku as e', 'e.id', '=', 'b.sku_id')
                    ->leftJoin('trans_sales_order_details as f', 'f.id', '=', 'c.sales_order_details_id')
                    ->leftJoin('trans_sales_order as g', 'g.id', '=', 'f.id_sales_order')
                    ->leftJoin('trans_delivery_order as h', 'h.id', '=', 'b.delivery_order_id')
                    ->leftJoin('trans_customer_return as i', 'i.id', '=', 'a.customer_return_id')
                    ->where(function ($q) use ($request) {
                        if ($request->subDoType) {
                            $q->where('e.sku_type', $request->subDoType);
                        }
                        if ($request->customerId) {
                            $q->where('d.customer_id', $request->customerId);
                        }
                        if ($request->deliveryDestinationId) {
                            $q->where('c.customer_delivery_destination_id', $request->deliveryDestinationId);
                        }
                    })
                    ->where('a.outstanding_qty', '>', 0)
                    ->selectRaw('a.id, h.do_date as delivery_date, g.po_number, d.cds_code, i.return_do_number, e.sku_id, e.sku_name, e.sku_specification_code, e.sku_business_type, e.sku_model, a.return_qty, a.outstanding_qty')
                    ->get();
            } else {
                $data = [];
            }

            return response()->json([
                'success' => true,
                'message' => "Get delivery source successfully",
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Error Request, Exception Error!",
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function getItemDetail(Request $request)
    {
        try {
            if ($request->itemType == 'SKU') {
                $sku = SkuListVw::where('id', (int)$request->itemId)->selectRaw('id, sku_id, sku_name, sku_specification_code, sku_business_type, sku_model, val_conversion, NULL as po_number, NULL as cds_code')->first();
                $packaging = MasterSku::where('id', $sku->id)->select('sku_packaging_category_id', 'sku_packaging_partition_id', 'qty_per_partition')->first();
            } else if ($request->itemType == 'CDS') {
                $sku = DB::table('trans_customer_delivery_schedule_details as a')
                    ->leftJoin('trans_customer_delivery_schedule as b', 'b.id', '=', 'a.customer_delivery_schedule_id')
                    ->leftJoin('vw_app_list_mst_sku as c', 'c.id', '=', 'a.sku_id')
                    ->leftJoin('trans_sales_order_details as d', 'd.id', '=', 'a.sales_order_details_id')
                    ->leftJoin('trans_sales_order as e', 'e.id', '=', 'd.id_sales_order')
                    ->where('a.id', (int)$request->itemId)
                    ->selectRaw('c.id, c.sku_id, c.sku_name, c.sku_specification_code, c.sku_business_type, c.sku_model, a.outstanding as val_conversion, e.po_number, b.cds_code')->first();
                $packaging = MasterSku::where('id', $sku->id)->select('sku_packaging_category_id', 'sku_packaging_partition_id', 'qty_per_partition')->first();
            } else if ($request->itemType == 'CR') {
                $sku = CustomerReturnDetail::from('trans_customer_return_detail as a')
                    ->leftJoin('trans_delivery_order_detail as b', 'b.id', '=', 'a.delivery_order_detail_id')
                    ->leftJoin('trans_customer_delivery_schedule_details as c', function ($join) {
                        $join->on('c.id', '=', 'b.source_id')->where('b.source_type', 'CDS');
                    })->leftJoin('trans_customer_delivery_schedule as d', 'd.id', '=', 'c.customer_delivery_schedule_id')
                    ->leftJoin('vw_app_list_mst_sku as e', 'e.id', '=', 'b.sku_id')
                    ->leftJoin('trans_sales_order_details as f', 'f.id', '=', 'c.sales_order_details_id')
                    ->leftJoin('trans_sales_order as g', 'g.id', '=', 'f.id_sales_order')
                    ->where('a.id', (int)$request->itemId)
                    ->selectRaw('e.id, e.sku_id, e.sku_name, e.sku_specification_code, e.sku_business_type, e.sku_model, a.outstanding_qty as val_conversion, g.po_number, d.cds_code')->first();
                $packaging = MasterSku::where('id', $sku->id)->select('sku_packaging_category_id', 'sku_packaging_partition_id', 'qty_per_partition')->first();
            } else {
                $sku = null;
                $packaging = null;
            }

            if ($packaging->sku_packaging_category_id && $packaging->sku_packaging_partition_id && $packaging->qty_per_partition) {
                $packagingCategory = PackagingInformationCategory::select('id', 'total_stock')->where('id', $packaging->sku_packaging_category_id)->first();
                $packagingPartition = PackagingInformationPartition::select('id', 'capacity')->Where('id', $packaging->sku_packaging_partition_id)->first();
                $qtyPerPackaging = floatval($packagingPartition->capacity) * floatval($packaging->qty_per_partition);
                $data = [
                    "sku" => $sku,
                    "packagingCategory" => $packagingCategory,
                    "qtyPerPackaging" => $qtyPerPackaging,
                    "qtyPackaging" => floatval($packagingCategory->total_stock),
                    "totalQtyPackaging" => ceil(floatval($sku->val_conversion) / $qtyPerPackaging),
                ];
            } else {
                $data = [
                    "sku" => $sku,
                    "packagingCategory" => null,
                    "qtyPerPackaging" => 0,
                    "qtyPackaging" => 0,
                    "totalQtyPackaging" => 0,
                ];
            }

            return response()->json([
                'success' => true,
                'message' => "Get item detail successfully",
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Error Request, Exception Error!",
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function createDO(Request $request)
    {
        DB::beginTransaction();

        try {
            $destinationType = $request->doDestinationType == 'Customer' ? 'MUI-C' : 'MUI-S';
            if ($request->doType === 'Regular') {
                $doTypePrefix = 'REG';
                $doNumberLike = '%' . $destinationType . '/REG/%';
            } else if ($request->doType === 'Replacement') {
                $doTypePrefix = 'REP';
                $doNumberLike = '%' . $destinationType . '/REP/%';
            } else if ($request->doType === 'Sample Part') {
                $doTypePrefix = 'SAM';
                $doNumberLike = '%' . $destinationType . '/SAM/%';
            }

            $maxSeqNumber = DeliveryOrder::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))->where('do_number', 'like', $doNumberLike)
                ->max('do_number_seq');
            $doNumber = $this->generateDONumber('Customer', $doTypePrefix, $maxSeqNumber + 1);

            // Insert Delivery Order
            $insertDO = DeliveryOrder::create([
                'do_number' => $doNumber,
                'do_number_seq' => $maxSeqNumber + 1,
                'do_destination_type' => $request->doDestinationType,
                'do_date' => $request->doDate,
                'do_type' => $request->doType,
                'do_sub_type' => $request->subDoType,
                'customer_id' => (int)$request->customer,
                'customer_delivery_destination_id' => (int)$request->doDestination,
                'vehicle_id' => (int)$request->vehicle,
                'driver_id' => (int)$request->driver,
                'do_note' => $request->deliveryNote,
                'do_officer_id' => Auth::id(),
                'status' => 'READY',
                'created_by' => Auth::id(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Insert Delivery Order Detail
            $seqNumberDetail = 1;
            foreach ($request->listItem as $item) {
                $doNumberDetail = $this->generateDONumberDetail($doNumber, $seqNumberDetail);
                $insertDODetail = DeliveryOrderDetail::create([
                    'dod_number' => $doNumberDetail,
                    'dod_number_seq' => $seqNumberDetail,
                    'delivery_order_id' => $insertDO->id,
                    'source_type' => $item['type'],
                    'source_id' => (int)$item['id'],
                    'sku_id' => (int)$item['skuId'],
                    'qty' => (float)$item['qty'],
                    'packaging_category_id' => (int)$item['packagingCategoryId'],
                    'total_packaging' => (int)$item['totalPackaging'],
                    'created_by' => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                // Update Outstanding CDS
                if ($item['type'] == 'CDS') {
                    $latestOutstandingCDS = TransCustomerDeliveryScheduleDetails::where('id', (int)$item['id'])
                        ->select('id', 'outstanding')->first();
                    $remainingOutstanding = $latestOutstandingCDS->outstanding - (float)$item['qty'];
                    $updateOutstandingCDS = TransCustomerDeliveryScheduleDetails::where('id', (int)$item['id'])
                        ->update([
                            'outstanding' => $remainingOutstanding,
                            'outstanding_status' => $remainingOutstanding > 0 ? 1 : 0,
                            'delivery_status' => $remainingOutstanding > 0 ? 'PENDING' : 'DONE',
                            'updated_by' => Auth::id(),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                }

                // Update Outstanding CR
                if ($item['type'] == 'CR') {
                    $latestOutstandingCR = CustomerReturnDetail::where('id', (int)$item['id'])
                        ->select('id', 'outstanding_qty')->first();
                    $remainingOutstanding = $latestOutstandingCR->outstanding_qty - (float)$item['qty'];
                    $updateOutstandingCR = CustomerReturnDetail::where('id', (int)$item['id'])
                        ->update([
                            'outstanding_qty' => $remainingOutstanding,
                            'updated_by' => Auth::id(),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                }

                // Update stock packaging
                $latestStockPackaging = PackagingInformationCategory::where('id', (int)$item['packagingCategoryId'])
                    ->select('id', 'total_stock')->first();
                $updateStockPackaging = PackagingInformationCategory::where('id', (int)$item['packagingCategoryId'])
                    ->update([
                        'total_stock' => $latestStockPackaging->total_stock - (int)$item['totalPackaging'],
                        'updated_by' => Auth::id(),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                $seqNumberDetail++;
            }

            foreach ($request->listItem as $item2) {
                // Check CDS Detail is not fully outstanding and update CDS status
                if ($item2['type'] == 'CDS') {
                    $getCDSId = TransCustomerDeliveryScheduleDetails::where('id', (int)$item2['id'])->select('customer_delivery_schedule_id')->first();
                    $checkOutstandingCDS = TransCustomerDeliveryScheduleDetails::where('customer_delivery_schedule_id', $getCDSId->customer_delivery_schedule_id)
                        ->where('outstanding', '>', 0)->count();
                    if ($checkOutstandingCDS === 0) {
                        TransCustomerDeliverySchedule::where('id', $getCDSId->customer_delivery_schedule_id)
                            ->update([
                                'cds_status' => 0,
                                'updated_by' => Auth::id(),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Create delivery order successfully",
                'data' => $insertDO
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

    public function generateDONumber($category, $type, $sequence)
    {
        $prefixDONumber = $category === 'Customer' ? 'MUI-C' : 'MUI-S';
        $paddedSequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);
        $year = date('y');
        $month = date('m');

        return "{$prefixDONumber}/{$type}/{$year}/{$month}/{$paddedSequence}";
    }

    public function generateDONumberDetail($doNumber, $subSequence)
    {
        $paddedSub = str_pad($subSequence, 3, '0', STR_PAD_LEFT);

        return "{$doNumber}-{$paddedSub}";
    }

    public function exportPDF(Request $request)
    {
        try {
            $deliveryOrder = DeliveryOrder::from('trans_delivery_order as a')
                ->leftJoin('mst_customer as b', function ($join) {
                    $join->on('b.id', '=', 'a.customer_id')->where('a.do_destination_type', '=', 'Customer');
                })->leftJoin('mst_person_supplier as c', function ($join) {
                    $join->on('b.id', '=', 'a.supplier_id')->where('a.do_destination_type', '=', 'Supplier');
                })->leftJoin('auth_user as d', 'd.id', '=', 'a.do_officer_id')
                ->leftJoin('mst_customer_delivery_destination as e', 'e.id', '=', 'a.customer_delivery_destination_id')
                ->where('a.id', $request->id)
                ->selectRaw('a.*, b.name as customer_name, c.description as supplier_name, d.fullname as do_officer_name, e.destination_address')->first();

            $items = DeliveryOrderDetail::from('trans_delivery_order_detail as a')
                ->leftJoin('vw_app_list_mst_sku as b', 'b.id', '=', 'a.sku_id')
                ->leftJoin('mst_packaging_information_category as c', 'c.id', '=', 'a.packaging_category_id')
                ->leftJoin('trans_customer_delivery_schedule_details as d', function ($join) {
                    $join->on('d.id', '=', 'a.source_id')->where('a.source_type', '=', 'CDS');
                })
                ->leftJoin('trans_sales_order_details as e', 'e.id', '=', 'd.sales_order_details_id')
                ->leftJoin('trans_sales_order as f', 'f.id', '=', 'e.id_sales_order')
                ->leftJoin('trans_customer_delivery_schedule as g', 'g.id', '=', 'd.customer_delivery_schedule_id')
                ->leftJoin('mst_customer_delivery_destination as h', 'h.id', '=', 'd.customer_delivery_destination_id')
                ->leftJoin('trans_customer_return_detail as cc', function ($join) {
                    $join->on('cc.id', '=', 'a.source_id')->where('a.source_type', '=', 'CR');
                })
                ->leftJoin('trans_customer_return as dd', 'dd.id', '=', 'cc.customer_return_id')
                ->leftJoin('trans_delivery_order_detail as ee', 'ee.id', '=', 'cc.delivery_order_detail_id')
                ->leftJoin('trans_customer_delivery_schedule_details as ff', function ($join) {
                    $join->on('ff.id', '=', 'ee.source_id')->where('ee.source_type', '=', 'CDS');
                })
                ->leftJoin('trans_sales_order_details as gg', 'gg.id', '=', 'ff.sales_order_details_id')
                ->leftJoin('trans_sales_order as hh', 'hh.id', '=', 'gg.id_sales_order')
                ->leftJoin('trans_customer_delivery_schedule as ii', 'ii.id', '=', 'ff.customer_delivery_schedule_id')
                ->leftJoin('mst_customer_delivery_destination as jj', 'jj.id', '=', 'ff.customer_delivery_destination_id')
                ->where('a.delivery_order_id', $request->id)
                ->selectRaw('a.id, a.qty, a.source_type, a.total_packaging, b.sku_name, c.description, f.po_number as po_number_cds, hh.po_number as po_number_cr, g.customer_delivery_number as customer_delivery_number_cds, ii.customer_delivery_number as customer_delivery_number_cr, dd.return_do_number as return_do_number_cr, h.destination_name as delivery_destination_cds, jj.destination_name as delivery_destination_cr, h.destination_address as delivery_destination_address_cds, jj.destination_address as delivery_destination_address_cr, h.destination_code as delivery_destination_code_cds, jj.destination_code as delivery_destination_code_cr, b.sku_inventory_unit, b.sku_specification_code')
                ->get();

            $data = [
                'title' => "Delivery Order",
                "data" => $deliveryOrder,
                "items" => $items,
                "option" => $request->option,
                "isOtherDestination" => $request->otherDestination == '1' ? true : false,
            ];

            // $pdf = Pdf::loadView('transaction.inventory.delivery_order.pdf', $data)->setPaper('a4', 'landscape');;

            // return response($pdf->output(), 200, [
            //     'Content-Type' => 'application/pdf',
            //     'Content-Disposition' => 'inline; filename="delivery-order.pdf"',
            // ]);
            $pdf = Pdf::loadView(
                'transaction.inventory.delivery_order.pdf2',
                $data
            )->setPaper('a4', 'portrait');

            // $customPaper = [0, 0, 609.45, 453.54];

            // $pdf = Pdf::loadView(
            //     'transaction.inventory.delivery_order.pdf2',
            //     $data
            // )->setPaper($customPaper, 'portrait');

            return $pdf->stream('delivery_order.pdf');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error Request, Exception Error!');
        }
    }

    public function deleteDO(Request $request)
    {
        DB::beginTransaction();

        try {
            $deliveryOrder = DeliveryOrder::where('id', $request->id)->first();
            if (!$deliveryOrder) {
                return response()->json([
                    'success' => false,
                    'message' => "Delivery Order not found!",
                    'data' => null
                ], 404);
            }

            // Get DO Detail
            $doDetails = DeliveryOrderDetail::where('delivery_order_id', $request->id)->get();

            // Check if DO has been used in invoice with detail ids
            $checkInvoice = TransSalesInvoiceDetail::whereIn('delivery_order_detail_id', $doDetails->pluck('id'))
                ->whereNull('deleted_at')
                ->count();
            if ($checkInvoice > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot delete delivery order, this delivery order has been used in invoice!",
                    'data' => null
                ], 400);
            }

            if ($deliveryOrder->do_type == 'Regular') {
                // Update back outstanding CDS
                foreach ($doDetails as $detail) {
                    if ($detail->source_type == 'CDS') {
                        TransCustomerDeliveryScheduleDetails::where('id', $detail->source_id)
                            ->update([
                                'outstanding' => DB::raw('outstanding + ' . $detail->qty),
                                'outstanding_status' => 1,
                                'delivery_status' => 'PENDING',
                                'updated_by' => Auth::id(),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                    }
                }
            } else if ($deliveryOrder->do_type == 'Replacement') {
                // Update back outstanding CR
                foreach ($doDetails as $detail) {
                    if ($detail->source_type == 'CR') {
                        CustomerReturnDetail::where('id', $detail->source_id)
                            ->update([
                                'outstanding_qty' => DB::raw('outstanding_qty + ' . $detail->qty),
                                'updated_by' => Auth::id(),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                    }
                }
            } else if ($deliveryOrder->do_type == 'Sample Part') {
                // Update back stock packaging
                foreach ($doDetails as $detail) {
                    PackagingInformationCategory::where('id', $detail->packaging_category_id)
                        ->update([
                            'total_stock' => DB::raw('total_stock + ' . $detail->total_packaging),
                            'updated_by' => Auth::id(),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                }
            }

            // Delete DO Detail
            DeliveryOrderDetail::where('delivery_order_id', $request->id)->update([
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => Auth::id(),
            ]);

            // Delete DO
            DeliveryOrder::where('id', $request->id)->update([
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => Auth::id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Delete delivery order successfully",
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Error Request, Exception Error!",
                'data' => $e->getMessage()
            ], 500);
        }
    }
}
