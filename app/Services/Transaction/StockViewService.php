<?php

namespace App\Services\Transaction;

use App\Models\Transaction\Pricelist\SkuPricelistVw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockViewService
{
    public function list(){
          return SkuPricelistVw::where('flag_pricelist_status', 1)->get();;
    }

    
    public function get_all(Request $request){
        $start = $request->input('start'); // Start index untuk pagination
        $length = $request->input('length'); // Jumlah data per halaman
        $search = $request->input('search.value'); // Pencarian global
        $orderColumnIndex = $request->input('order.0.column'); // Indeks kolom yang diurutkan
        $orderDirection = $request->input('order.0.dir'); // Arah pengurutan (asc/desc)
        $columns = $request->input('columns'); // Semua kolom

        $query = DB::table('vw_app_report_sku_stock_balance');

        if ($request->date != null) {
            $query->where('report_date', [$request->date]);
        }

        // if (!empty($search)) {
        //     $query->where(function ($q) use ($search) {
        //         $q->where('trans_purchase_order.manual_id', 'like', '%' . $search . '%')
        //             ->orWhere('trans_purchase_order.doc_num', 'like', '%' . $search . '%')
        //             ->orWhere('mst_person_supplier.description', 'like', '%' . $search . '%')
        //             ->orWhere('trans_purchase_order.description', 'like', '%' . $search . '%');
        //     });
        // }

        $recordsTotal = $query->count();

        $recordsFiltered = $query->count();

        $data = $query->get();
        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' =>  $recordsFiltered
        ];
    }
    
    public function sync(Request $request){
        $userId =  Auth::id();
        DB::statement('CALL sp_report_generate_sku_stock_balance(?,?)', [$request->date, $userId]);
        DB::statement('CALL sp_report_generate_sku_outstanding(?,?)', [$request->date, $userId]);
    }

}