<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use App\Imports\CustomerDeliveryScheduleImport;
use App\Models\MasterCustomerDeliveryDestination;
use App\Models\Transaction\Inventory\MstSku;
use App\Models\Transaction\Inventory\TransCustomerDeliverySchedule;
use App\Models\Transaction\Inventory\TransCustomerDeliveryScheduleDetails;
use App\Models\Transaction\Sales\TransSalesOrder;
use App\Models\Transaction\Sales\TransSalesOrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ])
            ->where('trans_sales_order_details.outstanding', '>', 0)
            ->where('trans_sales_order.so_status', '!=', 3);

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

                $sod = TransSalesOrderDetails::find($item['id']);
                if ($sod) {
                    $sod->outstanding = max(0, $sod->outstanding - $item['quantity_order']);
                    $sod->updated_by = Auth::id();
                    $sod->save();

                    $salesOrderId = $sod->id_sales_order;

                    $remainingOutstanding = TransSalesOrderDetails::where('id_sales_order', $salesOrderId)
                        ->where('outstanding', '>', 0)
                        ->exists();

                    if (!$remainingOutstanding) {
                        TransSalesOrder::where('id', $salesOrderId)
                            ->update(['so_status' => 0, 'updated_by' => Auth::id()]);
                    }
                }

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

    public function api_droplist_customer_delivery_schedule_list(Request $request)
    {
        $query = TransCustomerDeliverySchedule::query()
            ->join('mst_customer', 'trans_customer_delivery_schedule.customer_id', '=', 'mst_customer.id')
            ->leftJoin(
                'trans_customer_delivery_schedule_details as cdsd',
                'trans_customer_delivery_schedule.id',
                '=',
                'cdsd.customer_delivery_schedule_id'
            )
            ->select([
                'trans_customer_delivery_schedule.*',
                'mst_customer.name as customer_name',
                DB::raw("
            CASE 
                WHEN COUNT(cdsd.id) = SUM(
                    CASE 
                        WHEN cdsd.outstanding = cdsd.quantity_cds 
                        THEN 1 ELSE 0 
                    END
                )
                THEN 1 ELSE 0
            END as can_delete
        ")
            ])
            ->where('trans_customer_delivery_schedule.cds_status', '!=', 3)
            ->groupBy('trans_customer_delivery_schedule.id', 'mst_customer.name');

        if ($request->filled('customer_delivery_schedule_details')) {
            $query->where('trans_customer_delivery_schedule.customer_id', $request->customer_delivery_schedule_details);
        }

        if (
            $request->filled('valid_from_customer_delivery_schedule_details') ||
            $request->filled('valid_until_customer_delivery_schedule_details')
        ) {
            $from  = $request->valid_from_customer_delivery_schedule_details ?? '1900-01-01';
            $until = $request->valid_until_customer_delivery_schedule_details ?? '2999-12-31';

            $query->whereDate('trans_customer_delivery_schedule.valid_from', '<=', $until)
                ->whereDate('trans_customer_delivery_schedule.valid_until', '>=', $from);
        }

        if (!empty($request->search['value'])) {
            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {
                $q->where('trans_customer_delivery_schedule.cds_code', 'like', "%{$search}%")
                    ->orWhere('trans_customer_delivery_schedule.cds_date', 'like', "%{$search}%")
                    ->orWhere('trans_customer_delivery_schedule.customer_delivery_number', 'like', "%{$search}%")
                    ->orWhere('mst_customer.name', 'like', "%{$search}%")
                    ->orWhere('trans_customer_delivery_schedule.valid_from', 'like', "%{$search}%")
                    ->orWhere('trans_customer_delivery_schedule.valid_until', 'like', "%{$search}%");
            });
        }

        $totalData = TransCustomerDeliverySchedule::count();
        $recordsFiltered = (clone $query)->count();

        $data = $query
            ->orderBy('trans_customer_delivery_schedule.valid_from', 'desc')
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

    public function api_droplist_customer_delivery_schedule_list_detail(Request $request)
    {
        $query = TransCustomerDeliveryScheduleDetails::query()
            ->join('vw_app_list_mst_sku', 'trans_customer_delivery_schedule_details.sku_id', '=', 'vw_app_list_mst_sku.id')
            ->join('mst_customer_delivery_destination', 'trans_customer_delivery_schedule_details.customer_delivery_destination_id', '=', 'mst_customer_delivery_destination.id')
            ->select([
                'trans_customer_delivery_schedule_details.*',
                'vw_app_list_mst_sku.sku_id as sku_id',
                'vw_app_list_mst_sku.sku_name as sku_name',
                'vw_app_list_mst_sku.sku_specification_code as sku_specification_code',
                'vw_app_list_mst_sku.sku_inventory_unit as sku_inventory_unit',
                'mst_customer_delivery_destination.destination_name as destination_name'
            ])->where('trans_customer_delivery_schedule_details.customer_delivery_schedule_id', $request->customer_delivery_schedule_id);

        if (!empty($request->search['value'])) {
            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {
                $q->where('vw_app_list_mst_sku.sku_id', 'like', "%{$search}%")
                    ->orWhere('vw_app_list_mst_sku.sku_name', 'like', "%{$search}%")
                    ->orWhere('vw_app_list_mst_sku.sku_specification_code', 'like', "%{$search}%")
                    ->orWhere('vw_app_list_mst_sku.sku_inventory_unit', 'like', "%{$search}%");
            });
        }


        $totalData = TransCustomerDeliveryScheduleDetails::where(
            'trans_customer_delivery_schedule_details.customer_delivery_schedule_id',
            $request->customer_delivery_schedule_id
        )->count();

        $recordsFiltered = (clone $query)->count();

        $data = $query
            ->orderBy('trans_customer_delivery_schedule_details.id', 'desc')
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

    private function generateSoNumber()
    {
        $year = now()->format('y');
        $month = now()->format('m');

        $last = TransSalesOrder::whereYear('so_date', now()->year)
            ->whereMonth('so_date', now()->month)
            ->max('so_number_seq');

        $seq = ($last ?? 0) + 1;

        return [
            'seq' => $seq,
            'number' => sprintf("SO-%s/%s/%04d", $year, $month, $seq)
        ];
    }

    private function generateSodNumber($soNumber, $seq)
    {
        return sprintf("SOD-%s-%03d", $soNumber, $seq);
    }

    function extelToDate($excelDate)
    {
        $unixTimestamp = ($excelDate - 25569) * 86400;
        return date("Y-m-d", $unixTimestamp);
    }

    public function api_import_customer_delivery_schedule(Request $request)
    {
        DB::beginTransaction();

        // Validasi file
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            // Excel to array
            $file = $request->file('file');
            $fileData = \Excel::toArray(CustomerDeliveryScheduleImport::class, $file);
            $data = $fileData[0] ?? [];
            unset($data[0]);

            $SODetailList = [];
            foreach ($data as $row) {
                $checkSKU = MstSku::where('specification_code', trim($row[5]))->select('id', 'val_conversion')->first();
                if (!$checkSKU) {
                    return response()->json([
                        'status' => false,
                        'message' => "Part number '" . trim($row[5]) . "' not found",
                    ], 404);
                }
                if (floatval($row[13]) > floatval($checkSKU->val_conversion)) {
                    return response()->json([
                        'status' => false,
                        'message' => "Quantity for part number '" . trim($row[5]) . "' must be less than or equal " . floatval($checkSKU->val_conversion),
                    ], 400);
                }

                // Check pricelist
                $priceSKU = DB::table('trans_sku_pricelist as a')->select('a.id', 'a.price', 'a.price_retail', 'b.prefix')
                    ->leftJoin('mst_general_currency as b', 'a.gen_currency_id', '=', 'b.id')
                    ->where('a.sku_id', $checkSKU->id)
                    ->where('a.prs_customer_id', 19)->orderBy('a.valid_date_to', 'desc')->first();
                if (!$priceSKU) {
                    return response()->json([
                        'status' => false,
                        'message' => "Price for part number '" . trim($row[5]) . "' not found",
                    ], 404);
                }

                // Get customer delivery destination
                $customerDeliveryDestination = MasterCustomerDeliveryDestination::where('customer_id', 19)->where('destination_code', trim($row[3]))->where('flag_active', 1)->first('id');

                $SODetailList[] = [
                    'sku_id' => $checkSKU->id,
                    'val_conversion' => floatval($checkSKU->val_conversion),
                    'quantity_order' => floatval($row[13]),
                    'price' => floatval($priceSKU->price),
                    'price_retail' => floatval($priceSKU->price_retail),
                    'currency' => $priceSKU->prefix,
                    'cds_delivery_date' => $row[10] ? $this->extelToDate($row[10]) : date('Y-m-d', strtotime(strval($row[9]))),
                    'customer_delivery_destination_id' => $customerDeliveryDestination->id ?? null,
                ];
            }

            $soNumberData = $this->generateSoNumber();

            $salesOrder = TransSalesOrder::create([
                'so_number'      => $soNumberData['number'],
                'so_number_seq'  => $soNumberData['seq'],
                'so_date'        => now()->toDateString(),
                'so_type'        => '',
                'po_number'      => NULL,
                'customer_id'    => 19,
                'valid_from'     => $SODetailList[0]['cds_delivery_date'],
                'valid_until'    => end($SODetailList)['cds_delivery_date'],
                'validation_status' => 'UP TO DATE',
                'created_by'     => Auth::id(),
            ]);

            $seq = 1;
            foreach ($SODetailList as $item) {
                $soDetail = TransSalesOrderDetails::create([
                    'sod_number'      => $this->generateSodNumber($soNumberData['number'], $seq),
                    'sod_number_seq'  => $seq,
                    'id_sales_order' => $salesOrder->id,
                    'sku_id'          => $item['sku_id'],
                    'quantity_order' => $item['quantity_order'],
                    'outstanding'    => 0,
                    'term_of_payment' => 100,
                    'currency'       => $item['currency'],
                    'price'          => $item['price'],
                    'retail_price'   => $item['price_retail'],
                    'total_price'    => $item['quantity_order'] * $item['price'],
                    'exchange_rates' => 1,
                    'created_by'     => Auth::id(),
                ]);

                // Update sku stock
                $sku = MstSku::where('id', $item['sku_id'])->update([
                    'val_conversion' => $item['val_conversion'] - $item['quantity_order'],
                ]);

                $SODetailList[$seq - 1]['sales_order_details_id'] = $soDetail->id;

                $seq++;
            }

            $cdsNumberData = $this->generateCdsNumber();

            $cds = TransCustomerDeliverySchedule::create([
                'cds_code'        => $cdsNumberData['number'],
                'cds_code_seq'    => $cdsNumberData['seq'],
                'cds_date'        => now()->toDateString(),
                'customer_delivery_number' => NULL,
                'customer_id'     => 19,
                'valid_from'      => $SODetailList[0]['cds_delivery_date'],
                'valid_until'     => end($SODetailList)['cds_delivery_date'],
                'validation_status' => 'UP TO DATE',
                'cds_status'      => 1,
                'created_by'      => Auth::id(),
            ]);

            $seqCDS = 1;
            foreach ($SODetailList as $item2) {
                TransCustomerDeliveryScheduleDetails::create([
                    'cdsd_code'                    => $this->generateCdsdNumber($cdsNumberData['number'], $seqCDS),
                    'cdsd_code_seq'                => $seqCDS,
                    'customer_delivery_schedule_id' => $cds->id,
                    'delivery_plan_date'           => $item2['cds_delivery_date'],
                    'sku_id'                       => $item2['sku_id'],
                    'customer_delivery_destination_id' => $item2['customer_delivery_destination_id'],
                    'sales_order_details_id'       => $item2['sales_order_details_id'],
                    'quantity_cds'                 => $item2['quantity_order'],
                    'outstanding'                  => $item2['quantity_order'],
                    'valid_from'                   => $SODetailList[0]['cds_delivery_date'],
                    'valid_until'                  => end($SODetailList)['cds_delivery_date'],
                    'validation_status'            => 'UP TO DATE',
                    'delivery_status'              => 'PENDING',
                    'created_by'                   => Auth::id(),
                ]);

                $seqCDS++;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Import customer delivery schedule successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Internal server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function api_delete_customer_delivery_schedule(Request $request)
    {
        DB::beginTransaction();

        try {

            $cds = TransCustomerDeliverySchedule::findOrFail($request->id);

            $hasUsedDetail = TransCustomerDeliveryScheduleDetails::where(
                'customer_delivery_schedule_id',
                $cds->id
            )
                ->whereColumn('outstanding', '<', 'quantity_cds')
                ->exists();

            if ($hasUsedDetail) {
                return response()->json([
                    'status' => false,
                    'message' => 'CDS tidak bisa dihapus karena sudah diproses'
                ]);
            }

            $cdsDetails = TransCustomerDeliveryScheduleDetails::where(
                'customer_delivery_schedule_id',
                $cds->id
            )->get();

            foreach ($cdsDetails as $detail) {

                $sod = TransSalesOrderDetails::find($detail->sales_order_details_id);

                if ($sod) {

                    $sod->outstanding += $detail->quantity_cds;
                    $sod->updated_by = Auth::id();
                    $sod->save();

                    $salesOrderId = $sod->id_sales_order;

                    $hasRemainingOutstanding = TransSalesOrderDetails::where('id_sales_order', $salesOrderId)
                        ->where('outstanding', '>', 0)
                        ->exists();

                    if ($hasRemainingOutstanding) {
                        TransSalesOrder::where('id', $salesOrderId)
                            ->update([
                                'so_status' => 1,
                                'updated_by' => Auth::id()
                            ]);
                    }
                }
            }

            $cds->cds_status = 3;
            $cds->updated_by = Auth::id();
            $cds->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Customer Delivery Schedule berhasil dihapus & SO dikembalikan'
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
