<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PurchaseAnalysisFrequencyController
{

    public function index(): Response
    {
        return response()->view('transaction.pa.index_frequeny');
    }
    
    public function get_frequency_summary_by(Request $request)
    {
        $query = DB::table('vw_app_summary_report_purchase_frequency');
        
        $query->whereBetween('trans_date', [$request->input('startDate'), $request->input('endDate')]);

        if ($request->input('gen_department_id') != null) {
            $query->where('gen_department_id', $request->input('gen_department_id'));
        }

        // Group by manual untuk menghilangkan duplikat
        $data = $query->get()->groupBy('gen_department_id')->map(function ($group) {
            return [
                'gen_department_id' => $group->first()->gen_department_id,
                'department' => $group->first()->department,
                'currency' => $group->first()->currency,
                'total' => $group->sum('total')
            ];
        })->values();

        return response()->json([
            'data' => $data
        ]);
    }
    
    public function get_frequency_list_by(Request $request)
    {
        $query = DB::table('vw_app_list_trans_pi_dt');
        
         
        $query->whereBetween('trans_date', [$request->input('startDate'), $request->input('endDate')]);

        if ($request->input('gen_department_id') != null) {
            $query->where('gen_department_id', $request->input('gen_department_id'));
        }


        $data = $query->orderBy('trans_date')->get();

        return response()->json([
            'data' => $data
        ]);
    }   


}