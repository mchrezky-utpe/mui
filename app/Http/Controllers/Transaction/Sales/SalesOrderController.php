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

        if ($request->filled('valid_from')) {
            $query->whereDate('valid_date_from', '>=', $request->valid_from);
        }

        if ($request->filled('valid_until')) {
            $query->whereDate('valid_date_to', '<=', $request->valid_until);
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
}
