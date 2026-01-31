<?php

namespace App\Http\Controllers\Transaction\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Master\General\GeneralCurrency;
use App\Models\Master\Sku\SkuCategoryListVw;
use App\Models\Transaction\Pricelist\SkuPricelistVw;
use App\Models\Transaction\Sales\TransSalesOrder;
use App\Models\Transaction\Sales\TransSalesOrderDetails;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\Inventory\MstSku;

class SalesOrderController extends Controller
{

    public function index()
    {
        $data = [
            'css'     => 'transaction/sales/sales_order/css',
            'content' => 'transaction/sales/sales_order/index',
            'script'  => 'transaction/sales/sales_order/script',
        ];

        return view('transaction/sales/sales_order/index', $data);
    }

    public function api_droplist_list_customer(Request $request)
    {
        $data = DB::table('mst_customer')
            ->select('id', 'name')
            ->where('flag_active', 1)
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    public function api_droplist_list_currency(Request $request)
    {
        $data = GeneralCurrency::select('id', 'prefix')->where('flag_active', 1)->orderBy('prefix')->get();

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    public function api_droplist_list_category(Request $request)
    {
        $data = SkuCategoryListVw::select('id', 'description')->where('id', '!=', 2)->orderBy('description')->get();

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    public function api_droplist_product_pricelist(Request $request)
    {
        $query = SkuPricelistVw::where('flag_pricelist_status', 1);

        if ($request->filled('customer')) {
            $query->where('prs_customer_id', $request->customer);
        }

        if ($request->filled('valid_from') && $request->filled('valid_until')) {
            $query->where(function ($q) use ($request) {
                $q->whereDate('valid_date_from', '<=', $request->valid_until)
                    ->whereDate('valid_date_to', '>=', $request->valid_from);
            });
        }

        if ($request->filled('type_item')) {
            $typeItem = ucfirst(strtolower($request->type_item));
            $query->where('sku_type', $typeItem);
        }

        if ($request->search && $request->search['value']) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('sku_id', 'like', "%{$search}%")
                    ->orWhere('sku_name', 'like', "%{$search}%")
                    ->orWhere('sku_specification_code', 'like', "%{$search}%")
                    ->orWhere('sku_type', 'like', "%{$search}%")
                    ->orWhere('currency', 'like', "%{$search}%");
            });
        }

        $totalData = SkuPricelistVw::where('flag_pricelist_status', 1)->count();
        $recordsFiltered = $query->count();

        $data = $query
            ->orderBy('valid_date_from', 'desc')
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

    public function api_insert_sales_order(Request $request)
    {
        DB::beginTransaction();

        try {
            if ($request->po_number) {
                $exists = TransSalesOrder::where('po_number', $request->po_number)->exists();
                if ($exists) {
                    return response()->json([
                        'status' => false,
                        'message' => 'PO Number sudah digunakan'
                    ], 400);
                }
            }

            $soNumberData = $this->generateSoNumber();

            $salesOrder = TransSalesOrder::create([
                'so_number'      => $soNumberData['number'],
                'so_number_seq'  => $soNumberData['seq'],
                'so_date'        => now()->toDateString(),
                'so_type'        => '',
                'po_number'      => $request->po_number,
                'customer_id'    => $request->customer_id,
                'valid_from'     => $request->valid_from,
                'valid_until'    => $request->valid_until,
                'validation_status' => 'UP TO DATE',
                'created_by'     => Auth::id(),
            ]);

            $seq = 1;
            foreach ($request->items as $item) {
                TransSalesOrderDetails::create([
                    'sod_number'      => $this->generateSodNumber($soNumberData['number'], $seq),
                    'sod_number_seq'  => $seq,
                    'id_sales_order' => $salesOrder->id,
                    'sku_id'          => MstSku::where('manual_id', $item['sku_id'])->first()->id,
                    'quantity_order' => $item['qty'],
                    'outstanding'    => $item['outstanding'],
                    'term_of_payment' => $item['top'],
                    'currency'       => $item['currency'],
                    'price'          => $item['price'],
                    'retail_price'   => $item['price'],
                    'total_price'    => $item['amount'],
                    'exchange_rates' => $item['exchange_rate'],
                    'created_by'     => Auth::id(),
                ]);

                $seq++;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Sales Order berhasil disimpan',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function api_droplist_sales_order_list(Request $request)
    {
        $query = TransSalesOrder::query()
            ->join('mst_customer', 'trans_sales_order.customer_id', '=', 'mst_customer.id')
            ->select([
                'trans_sales_order.*',
                'mst_customer.id as customer_id',
                'mst_customer.name as customer_name'
            ]);

        if ($request->filled('customer_sales_order_details')) {
            $query->where('trans_sales_order.customer_id', $request->customer_sales_order_details);
        }

        if (
            $request->filled('valid_from_sales_order_details') ||
            $request->filled('valid_until_sales_order_details')
        ) {
            $from  = $request->valid_from_sales_order_details ?? '1900-01-01';
            $until = $request->valid_until_sales_order_details ?? '2999-12-31';

            $query->whereDate('trans_sales_order.valid_from', '<=', $until)
                ->whereDate('trans_sales_order.valid_until', '>=', $from);
        }

        if (!empty($request->search['value'])) {
            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {
                $q->where('trans_sales_order.so_number', 'like', "%{$search}%")
                    ->orWhere('trans_sales_order.so_date', 'like', "%{$search}%")
                    ->orWhere('trans_sales_order.po_number', 'like', "%{$search}%")
                    ->orWhere('trans_sales_order.ref_number', 'like', "%{$search}%")
                    ->orWhere('mst_customer.name', 'like', "%{$search}%")
                    ->orWhere('trans_sales_order.valid_from', 'like', "%{$search}%")
                    ->orWhere('trans_sales_order.valid_until', 'like', "%{$search}%");
            });
        }

        $totalData = TransSalesOrder::count();
        $recordsFiltered = (clone $query)->count();

        $data = $query
            ->orderBy('trans_sales_order.valid_from', 'desc')
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

    public function api_droplist_sales_order_list_detail(Request $request)
    {
        $query = TransSalesOrderDetails::query()
            ->join('vw_app_list_mst_sku', 'trans_sales_order_details.sku_id', '=', 'vw_app_list_mst_sku.id')
            ->select([
                'trans_sales_order_details.*',
                'vw_app_list_mst_sku.sku_id as sku_id',
                'vw_app_list_mst_sku.sku_name as sku_name',
                'vw_app_list_mst_sku.sku_specification_code as sku_specification_code',
                'vw_app_list_mst_sku.sku_inventory_unit as sku_inventory_unit',
            ])->where('trans_sales_order_details.id_sales_order', $request->sales_order_id);

        if (!empty($request->search['value'])) {
            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {
                $q->where('vw_app_list_mst_sku.sku_id', 'like', "%{$search}%")
                    ->orWhere('vw_app_list_mst_sku.sku_name', 'like', "%{$search}%")
                    ->orWhere('vw_app_list_mst_sku.sku_specification_code', 'like', "%{$search}%")
                    ->orWhere('vw_app_list_mst_sku.sku_inventory_unit', 'like', "%{$search}%");
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
}
