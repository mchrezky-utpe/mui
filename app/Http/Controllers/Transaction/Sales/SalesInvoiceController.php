<?php

namespace App\Http\Controllers\Transaction\Sales;

use Exception;
use Illuminate\Http\Request;
use App\Models\MasterCustomer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterGeneralCurrency;
use App\Models\VwMasterGeneralExchangeRates;
use App\Models\Transaction\Inventory\DeliveryOrder;
use App\Models\Transaction\Sales\TransSalesInvoice;
use App\Models\Transaction\Inventory\DeliveryOrderDetail;
use App\Models\Transaction\Sales\TransSalesInvoiceDetail;

class SalesInvoiceController extends Controller
{
    public function index()
    {
        try {
            $customers = MasterCustomer::select('id', 'name')->get();
            $currency = MasterGeneralCurrency::select('id', 'prefix')->whereNull('deleted_at')->get();

            $data = [
                'customers' => $customers,
                'currency' => $currency
            ];
            return view('transaction/sales/sales_invoice/index', $data);
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

            $query = TransSalesInvoice::leftJoin('mst_customer as a', 'a.id', '=', 'trans_sales_invoice.customer_id');

            $totalRecords = (clone $query)->count();

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('trans_sales_invoice.invoice_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('trans_sales_invoice.tax_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('a.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('trans_sales_invoice.invoice_phase', 'LIKE', '%' . $search . '%')
                        ->orWhere('trans_sales_invoice.currency', 'LIKE', '%' . $search . '%');
                });
            }

            $query->where(function ($q) use ($request) {
                if ($request->startDate) {
                    $q->where('trans_sales_invoice.invoice_date', '>=', $request->startDate);
                }
                if ($request->endDate) {
                    $q->where('trans_sales_invoice.invoice_date', '<=', $request->endDate);
                }
                if ($request->currency) {
                    $q->where('trans_sales_invoice.currency', $request->currency);
                }
            });

            $totalRecordWithFilter = (clone $query)->count();

            $data = $query->select('trans_sales_invoice.*', 'a.name as customer_name')->skip($start)->take($length)->get();

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

            $query = TransSalesInvoiceDetail::from('trans_sales_invoice_detail as a')
                ->leftJoin('trans_sales_invoice as b', 'b.id', '=', 'a.sales_invoice_id')
                ->leftJoin('trans_delivery_order_detail as c', 'c.id', '=', 'a.delivery_order_detail_id')
                ->leftJoin('vw_app_list_mst_sku as d', 'd.id', '=', 'a.sku_id');

            $totalRecords = (clone $query)->count();

            $query->where(function ($q) use ($request) {
                if ($request->startDate) {
                    $q->where('b.invoice_date', '>=', $request->startDate);
                }
                if ($request->endDate) {
                    $q->where('b.invoice_date', '<=', $request->endDate);
                }
                if ($request->currency) {
                    $q->where('b.currency', $request->currency);
                }
            });

            $totalRecordWithFilter = (clone $query)->count();

            $data = $query->selectRaw('a.id, a.sales_invoice_id, a.delivery_order_detail_id, a.sku_id, a.price, b.invoice_date, b.invoice_number, b.currency, b.exchange_rate, d.sku_id as item_code, d.sku_name, d.sku_specification_code, d.sku_inventory_unit, c.qty')
                ->skip($start)->take($length)->get();

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

    public function getSourceData(Request $request)
    {
        try {
            $draw   = $request->get('draw');
            $start  = $request->get('start');
            $length = $request->get('length');
            $search = $request->get('search')['value'];

            if ($request->searchType == 'doNumber') {
                $query = DeliveryOrder::from('trans_delivery_order as a')
                    ->leftJoin('trans_delivery_order_detail as b', function ($join) {
                        $join->on('b.delivery_order_id', '=', 'a.id')
                            ->where('b.source_type', '=', 'CDS');
                    })
                    ->leftJoin('trans_customer_delivery_schedule_details as c', 'c.id', '=', 'b.source_id')
                    ->leftJoin('trans_customer_delivery_schedule as d', 'd.id', '=', 'c.customer_delivery_schedule_id')
                    ->leftJoin('trans_sales_order_details as e', 'e.id', '=', 'c.sales_order_details_id')
                    ->leftJoin('trans_sales_order as f', 'f.id', '=', 'e.id_sales_order')
                    ->whereNotNull('b.id')
                    ->where('a.customer_id', $request->customer)
                    ->groupBy('a.id');

                $totalRecords = (clone $query)->count();

                $totalRecordWithFilter = (clone $query)->count();

                $data = $query->select(
                    'a.*',
                    DB::raw('MIN(d.cds_code) as cds_code'),
                    DB::raw('MIN(f.po_number) as po_number')
                )->skip($start)->take($length)->get();
            } else if ($request->searchType == 'part') {
                $query = DeliveryOrderDetail::from('trans_delivery_order_detail as a')
                    ->leftJoin('trans_customer_delivery_schedule_details as b', 'b.id', '=', 'a.source_id')
                    ->leftJoin('trans_customer_delivery_schedule as c', 'c.id', '=', 'b.customer_delivery_schedule_id')
                    ->leftJoin('trans_sales_order_details as d', 'd.id', '=', 'b.sales_order_details_id')
                    ->leftJoin('trans_sales_order as e', 'e.id', '=', 'd.id_sales_order')
                    ->leftJoin('vw_app_list_mst_sku as f', 'f.id', '=', 'a.sku_id')
                    ->leftJoin('trans_delivery_order as g', 'g.id', '=', 'a.delivery_order_id')
                    ->where('a.source_type', 'CDS')
                    ->where('g.customer_id', $request->customer)
                    ->whereNull('a.deleted_at');

                $totalRecords = (clone $query)->count();

                $totalRecordWithFilter = (clone $query)->count();

                $data = $query->selectRaw('a.*, d.currency, d.price, f.sku_id as item_code, f.sku_name, f.sku_specification_code, f.sku_inventory_unit, g.do_date, g.do_number, c.cds_code, e.po_number')->skip($start)->take($length)->get();
            } else {
                $totalRecords = 0;
                $totalRecordWithFilter = 0;
                $data = [];
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

    public function getSourceDetail(Request $request)
    {
        try {
            $data = DeliveryOrderDetail::from('trans_delivery_order_detail as a')
                ->leftJoin('trans_customer_delivery_schedule_details as b', 'b.id', '=', 'a.source_id')
                ->leftJoin('trans_customer_delivery_schedule as c', 'c.id', '=', 'b.customer_delivery_schedule_id')
                ->leftJoin('trans_sales_order_details as d', 'd.id', '=', 'b.sales_order_details_id')
                ->leftJoin('trans_sales_order as e', 'e.id', '=', 'd.id_sales_order')
                ->leftJoin('vw_app_list_mst_sku as f', 'f.id', '=', 'a.sku_id')
                ->leftJoin('trans_delivery_order as g', 'g.id', '=', 'a.delivery_order_id')
                ->where('a.source_type', 'CDS')
                ->whereNull('a.deleted_at')
                ->where('a.delivery_order_id', $request->id)
                ->selectRaw('a.*, d.currency, d.price, f.sku_id as item_code, f.sku_name, f.sku_specification_code, f.sku_inventory_unit, g.do_date, g.do_number, c.cds_code, e.po_number')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Get source detail successfully',
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

    public function getExchangeRate(Request $request)
    {
        try {
            $data = VwMasterGeneralExchangeRates::where('currency_prefix', $request->currency)->first();

            return response()->json([
                'success' => true,
                'message' => 'Get exchange rate successfully',
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

    public function createInvoice(Request $request)
    {
        DB::beginTransaction();

        try {
            // Check tax number exist
            $checkTaxNumber = TransSalesInvoice::where('tax_number', $request->taxNumber)->first('id');
            if ($checkTaxNumber) {
                return response()->json([
                    'success' => false,
                    'message' => "Tax number already exist",
                ], 400);
            }

            $partialPay = 100;
            $partialPay = floatval($request->totalPaymentAmount);

            // Create sales invoice
            $invoice = TransSalesInvoice::create([
                "invoice_number" => $request->invoiceNumber,
                "invoice_date" => $request->invoiceDate,
                "invoice_type" => $request->invoiceType,
                "invoice_phase" => $request->invoicePhase,
                "tax_number" => $request->taxNumber,
                "tax_date" => $request->invoiceDate,
                "customer_id" => (int)$request->customerId,
                "currency" => $request->currency,
                "exchange_rate" => $request->exchangeRate,
                "kmk_date" => $request->kmkDate,
                "kmk_number" => $request->kmkNumber,
                "terms_of_payment" => $request->termsOfPayment,
                "ppn_percentage" => floatval($request->ppnPercentage),
                "ppn_amount" => floatval($request->ppnAmount),
                "discount_percentage" => floatval($request->discountPercentage),
                "discount_amount" => floatval($request->discountAmount),
                "total_service_amount" => floatval($request->totalServiceAmount),
                "pph23_percentage" => floatval($request->pphPercentage),
                "pph23_amount" => floatval($request->pphAmount),
                "partial_pay_percentage" => floatval($request->partialPayPercentage),
                "partial_pay_amount" => floatval($request->partialPayAmount),
                "sub_total_amount" => floatval($request->subTotalAmount),
                "total_amount" => floatval($request->totalAmount),
                "grand_total_amount" => floatval($request->grandTotalAmount),
                "total_payment_amount" => floatval($request->totalPaymentAmount),
                "status" => 1,
                "created_by" => Auth::id(),
                "created_at" => date('Y-m-d H:i:s')
            ]);

            // Insert invoice detail
            foreach ($request->listItems as $item) {
                $invoiceDetail = TransSalesInvoiceDetail::create([
                    "sales_invoice_id" => $invoice->id,
                    "delivery_order_detail_id" => (int)$item["id"],
                    "sku_id" => (int)$item["skuId"],
                    "price" => floatval($item["price"]),
                    "created_by" => Auth::id(),
                    "created_at" => date('Y-m-d H:i:s')
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Create sales invoice successfully",
                'data' => $invoice
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
}
