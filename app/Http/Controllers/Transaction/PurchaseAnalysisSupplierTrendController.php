<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PurchaseAnalysisSupplierTrendController
{

    public function index(): Response
    {
        return response()->view('transaction.pa.index_supplier_trend');
    }
    
    public function get_summary_by(Request $request)
    {
        $query = DB::table('trans_purchase_order as tpo')
            ->select(
                'tpo.prs_supplier_id',
                'mps.description as supplier',
                DB::raw('ROUND(SUM(tpo.subtotal_f), 0) as total')
            )
            ->join('mst_person_supplier as mps', 'tpo.prs_supplier_id', '=', 'mps.id')
            ->leftJoin('mst_general_currency as mgc', 'mgc.id', '=', 'tpo.gen_currency_id')
            ->whereBetween('tpo.trans_date', [$request->input('startDate'), $request->input('endDate')])
            ->groupBy('tpo.prs_supplier_id', 'mps.description')
            ->orderBy('supplier', 'asc'); // Optional: urutkan dari total terbesar

        // Tambahkan limit jika ada parameter count
        if ($request->has('count') && $request->input('count') > 0) {
            $query->limit($request->input('count'));
        }

        $data = $query->get();

        return response()->json([
            'data' => $data
        ]);
    }
    
    public function get_po_list_by(Request $request)
    {
        $query = DB::table('vw_app_summary_report_purchase_supplier_trends');
        
        $query->whereBetween('trans_date', [$request->input('startDate'), $request->input('endDate')]);

        $data = $query->orderBy('supplier')->get();

        return response()->json([
            'data' => $data
        ]);
    }   


}