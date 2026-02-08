<?php

namespace App\Http\Controllers\Transaction\Sales;

use Exception;
use Illuminate\Http\Request;
use App\Models\MasterCustomer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\MasterGeneralCurrency;
use App\Models\Transaction\Inventory\DeliveryOrder;
use App\Models\Transaction\Inventory\DeliveryOrderDetail;

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
                    ->groupBy('a.id');

                $totalRecords = (clone $query)->count();

                $totalRecordWithFilter = (clone $query)->count();

                $data = $query->select(
                    'a.*',
                    DB::raw('MIN(d.cds_code) as cds_code'),
                    DB::raw('MIN(f.po_number) as po_number')
                )->skip($start)->take($length)->get();
            } else {
                $query = DeliveryOrderDetail::from('trans_delivery_order_detail as a')
                    ->leftJoin('trans_customer_delivery_schedule_details as b', 'b.id', '=', 'a.source_id')
                    ->leftJoin('trans_customer_delivery_schedule as c', 'c.id', '=', 'b.customer_delivery_schedule_id')
                    ->leftJoin('trans_sales_order_details as d', 'd.id', '=', 'b.sales_order_details_id')
                    ->leftJoin('trans_sales_order as e', 'e.id', '=', 'd.id_sales_order')
                    ->where('a.source_type', 'CDS');

                $totalRecords = (clone $query)->count();

                $totalRecordWithFilter = (clone $query)->count();

                $data = $query->select('a.*')->skip($start)->take($length)->get();
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
}
