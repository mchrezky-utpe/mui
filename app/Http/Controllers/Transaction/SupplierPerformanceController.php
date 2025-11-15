<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SupplierPerformanceController
{

    public function index(): Response
    {
        return response()->view('transaction.supplier_performance.index');
    }
    
    public function get_summary_by(Request $request)
    {
        $query = "
            SELECT 
                a.prs_supplier_id,
                a.supplier,
                a.total_late,
                a.rate,
                CASE 
                    WHEN a.rate > 95 THEN 'A' 
                    WHEN a.rate BETWEEN 90 AND 95 THEN 'B' 
                    WHEN a.rate BETWEEN 85 AND 90 THEN 'C' 
                    WHEN a.rate BETWEEN 75 AND 85 THEN 'D' 
                    WHEN a.rate < 75 THEN 'E' 
                END as delivery_grade
            FROM (
                SELECT
                    prs_supplier_id,
                    supplier,
                    (SUM(CASE WHEN flag_delivery = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100 as rate,
                    SUM(CASE WHEN flag_delivery <> 1 THEN 1 ELSE 0 END) as total_late
                FROM
                    vw_app_list_trans_sds_hd
                WHERE 
                    trans_date BETWEEN ? AND ?
                    AND (? IS NULL OR prs_supplier_id = ?)
                GROUP BY
                    prs_supplier_id,
                    supplier
            ) a
        ";

        $data = DB::select($query, [
            $request->input('startDate'),
            $request->input('endDate'),
            $request->input('prs_supplier_id'),
            $request->input('prs_supplier_id')
        ]);

        return response()->json([
            'data' => $data
        ]);
    }
    
    public function get_detail(Request $request)
    {
        $year = $request->input('year', date('Y')); // Default tahun sekarang
        
        // Generate semua bulan dari Januari hingga Desember
        $allMonths = [];
        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create($year, $month, 1);
            $allMonths[$date->format('m-Y')] = [
                'period' => $date->format('m-Y'),
                'period_label' => substr($date->format('F'), 0, 3),
                'prs_supplier_id' => $request->input('prs_supplier_id'),
                'supplier' => 'Supplier', // Default, akan diupdate nanti
                'total_on_schedule' => 0,
                'total_sds' => 0,
                'total_late' => 0,
                'on_time_percentage' => 0,
                'month_number' => $month
            ];
        }

        // Ambil data supplier name
        $supplierName = 'Supplier';
        if ($request->has('prs_supplier_id') && $request->input('prs_supplier_id') != null) {
            $supplier = DB::table('mst_person_supplier')
                ->where('id', $request->input('prs_supplier_id'))
                ->first();
            $supplierName = $supplier->description ?? 'Supplier';
        }

        // Ambil data dari database
        $startDate = $year . '-01-01';
        $endDate = $year . '-12-31';
        
        $query = DB::table('vw_app_list_trans_sds_hd')
            ->select(
                DB::raw("DATE_FORMAT(trans_date, '%m-%Y') as period"),
                DB::raw("DATE_FORMAT(trans_date, '%M %Y') as period_label"),
                'prs_supplier_id',
                'supplier',
                DB::raw('SUM(CASE WHEN flag_delivery = 1 THEN 1 ELSE 0 END) as total_on_schedule'),
                DB::raw('COUNT(*) as total_sds'),
                DB::raw('SUM(CASE WHEN flag_delivery <> 1 THEN 1 ELSE 0 END) as total_late'),
                DB::raw('ROUND((SUM(CASE WHEN flag_delivery = 1 THEN 1 ELSE 0 END) / COUNT(*) * 100), 2) as on_time_percentage'),
                DB::raw('MONTH(trans_date) as month_number')
            )
            ->whereBetween('trans_date', [$startDate, $endDate])
            ->groupBy(
                DB::raw("DATE_FORMAT(trans_date, '%m-%Y')"),
                DB::raw("DATE_FORMAT(trans_date, '%M %Y')"),
                'prs_supplier_id',
                'supplier',
                DB::raw('MONTH(trans_date)')
            )
            ->orderBy('month_number', 'asc');

        if ($request->has('prs_supplier_id') && $request->input('prs_supplier_id') != null) {
            $query->where('prs_supplier_id', $request->input('prs_supplier_id'));
        }

        $dbData = $query->get()->keyBy('period');

        // Merge data dari database ke semua bulan
        $result = [];
        foreach ($allMonths as $period => $monthData) {
            if (isset($dbData[$period])) {
                // Ada data di database
                $dbItem = $dbData[$period];
                $result[] = [
                    'period' => $dbItem->period,
                    'period_label' => substr($dbItem->period_label, 0, 3),
                    'prs_supplier_id' => $dbItem->prs_supplier_id,
                    'supplier' => $dbItem->supplier,
                    'total_on_schedule' => $dbItem->total_on_schedule,
                    'total_sds' => $dbItem->total_sds,
                    'total_late' => $dbItem->total_late,
                    'on_time_percentage' => $dbItem->on_time_percentage,
                    'month_number' => $dbItem->month_number
                ];
            } else {
                // Tidak ada data, gunakan default dengan supplier name yang benar
                $monthData['supplier'] = $supplierName;
                $result[] = $monthData;
            }
        }

        return response()->json([
            'data' => $result
        ]);
    }


}