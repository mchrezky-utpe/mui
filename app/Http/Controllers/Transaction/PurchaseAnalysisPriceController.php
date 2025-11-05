<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PurchaseAnalysisPriceController
{

    public function index(): Response
    {
        return response()->view('transaction.pa.index_price');
    }
    
    
    public function get_summary_by(Request $request)
    {
        $query = DB::table('vw_app_list_trans_sku_pricelist');
        
         
        $query->whereBetween('valid_date_from', [$request->input('startDate'), $request->input('endDate')]);

        if ($request->input('gen_supplier_id') != null) {
            $query->where('prs_supplier_id', $request->input('gen_supplier_id'));
        }


        $data = $query->orderBy('sku_id')->get();

        return response()->json([
            'data' => $data
        ]);
    }   
    
    
    public function get_price_list_by(Request $request)
    {
        $query = DB::table('vw_app_list_trans_sku_pricelist_history');
        
         
        $query->whereBetween('valid_date_from', [$request->input('startDate'), $request->input('endDate')]);

        if ($request->input('gen_supplier_id') != null) {
            $query->where('supplier_id', $request->input('gen_supplier_id'));
        }


        $data = $query->orderBy('valid_date_from')->get();

        return response()->json([
            'data' => $data
        ]);
    }   


}