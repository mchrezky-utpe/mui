<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PurchaseAnalysisOrderController
{

    public function index(): Response
    {
        return response()->view('transaction.pa.index_order');
    }
    
    
    public function get_summary_by(Request $request)
    {
        $query = DB::table('vw_app_summary_report_purchase_order_trends_detail');
        
          
        $query->whereBetween('trans_date', [$request->input('startDate'), $request->input('endDate')]);

        if ($request->input('supplier_id') != null) {
            $query->where('prs_supplier_id', $request->input('supplier_id'));
        }
 
        if ($request->input('gen_department_id') != null) {
            $query->where('gen_department_id', $request->input('gen_department_id'));
        }

        $data = $query->orderBy('supplier')->get();

        $data ;

        if($request->input('tabType') == "supplier"){
            // Group by manual untuk menghilangkan duplikat
            $data = $query->get()->groupBy('prs_supplier_id')->map(function ($group) {
                return [
                    'prs_supplier_id' => $group->first()->prs_supplier_id,
                    'supplier' => $group->first()->supplier
                ];
            })->values();
        }else{
            // Group by manual untuk menghilangkan duplikat
            $data = $query->get()->groupBy('gen_department_id')->map(function ($group) {
                return [
                    'gen_department_id' => $group->first()->gen_department_id,
                    'department' => $group->first()->department
                ];
            })->values();
        }

        return response()->json([
            'data' => $data
        ]);
    }   
    
    
    public function get_po_list_by(Request $request)
    {
        $query = DB::table('vw_app_summary_report_purchase_order_trends_detail');
        
         
        $query->whereBetween('trans_date', [$request->input('startDate'), $request->input('endDate')]);

        if($request->input('tabType') == "supplier"){
            $query->where('prs_supplier_id', $request->input('id'));
        }else{
            $query->where('gen_department_id', $request->input('id'));
        }


        $data = $query->orderBy('trans_date')->get();

        return response()->json([
            'data' => $data
        ]);
    }   


}