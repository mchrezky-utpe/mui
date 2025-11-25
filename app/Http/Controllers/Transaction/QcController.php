<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class QcController
{ 
    public function index(): Response
    {
        return response()->view('transaction.qc.index');
    }

    public function get_check_data(Request $request)
    {
        $query = DB::table('vw_app_list_trans_qc_check');
        
         
        $query->whereBetween('trans_date', [$request->input('startDate'), $request->input('endDate')]);

        $data = $query->orderBy('trans_date')->get();

        return response()->json([
            'data' => $data
        ]);
    }   
}