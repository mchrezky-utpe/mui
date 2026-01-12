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
	END as delivery_grade,
	round(a.ppm) ppm,
	CASE
		WHEN a.ppm = 0 THEN '-'
		WHEN a.ppm BETWEEN 1 AND 5000 THEN 'A'
		WHEN a.ppm BETWEEN 5001 AND 6500 THEN 'B'
		WHEN a.ppm BETWEEN 6501 AND 8000 THEN 'C'
		WHEN a.ppm BETWEEN 8001 AND 10000 THEN 'D'
		WHEN a.ppm > 10001 THEN 'E'
	END as qc_grade
FROM
	(
	select
		aa.prs_supplier_id,
		aa.supplier,
		sum(aa.rate) rate,
		sum(aa.total_late) total_late,
		sum(aa.ppm)ppm
	from
		(
		SELECT
			a.prs_supplier_id,
			supplier,
			(SUM(CASE WHEN flag_delivery = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100 as rate,
			SUM(CASE WHEN flag_delivery <> 1 THEN 1 ELSE 0 END) as total_late,
			0 as ppm
		FROM
			vw_app_list_trans_sds_hd a
		inner join trans_purchase_order tpo on
			tpo.id = a.trans_po_id
		WHERE
			tpo.trans_date BETWEEN ? AND ?
			AND (? IS NULL OR a.prs_supplier_id = ?)
		GROUP BY
			prs_supplier_id,
			supplier
	UNION
		SELECT
			a.prs_supplier_id,
			a.supplier,
			0 as rate,
			0 as total_late,
			sum(a.ppm) as ppm
		FROM
			vw_app_list_trans_qc_list a
		inner join trans_purchase_order tpo on
			tpo.id = a.trans_po_id
		WHERE
			tpo.trans_date BETWEEN ? AND ?
			AND (? IS NULL OR a.prs_supplier_id = ?)
		GROUP BY
			a.prs_supplier_id,
			a.supplier) aa
	group by
		aa.prs_supplier_id,
		aa.supplier) a
        ";

        $data = DB::select($query, [
            $request->input('startDate'),
            $request->input('endDate'),
            $request->input('prs_supplier_id'),
            $request->input('prs_supplier_id'),
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
        $year = $request->input('startDate');
        if ($year) {
            $year = Carbon::parse($year)->year;
        } else {
            $year = $request->input('year', date('Y'));
        }
        
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
    
    public function get_qc_detail(Request $request)
    {
        $year = $request->input('startDate');
        if ($year) {
            $year = Carbon::parse($year)->year;
        } else {
            $year = $request->input('year', date('Y'));
        }

        // Generate semua bulan dari Januari hingga Desember
        $allMonths = [];
        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create($year, $month, 1);
            $allMonths[$date->format('m-Y')] = [
                'period' => $date->format('m-Y'),
                'period_label' => substr($date->format('F'), 0, 3),
                'prs_supplier_id' => $request->input('prs_supplier_id'),
                'supplier' => 'Supplier', // Default, akan diupdate nanti
                'total_received' => 0,
                'total_ng' => 0,
                'total_ppm' => 0,
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
        
        $query = DB::table('vw_app_list_trans_qc_list')
            ->select(
                DB::raw("DATE_FORMAT(checking_date, '%m-%Y') as period"),
                DB::raw("DATE_FORMAT(checking_date, '%M %Y') as period_label"),
                'prs_supplier_id',
                'supplier',
                DB::raw('sum(qty_receiving) as qty_receiving'),
                DB::raw('sum(qty_ng) as qty_ng'),
                DB::raw('round(sum(ppm)) as ppm'),
                DB::raw('MONTH(checking_date) as month_number')
            )
            ->whereBetween('checking_date', [$startDate, $endDate])
            ->groupBy(
                DB::raw("DATE_FORMAT(checking_date, '%m-%Y')"),
                DB::raw("DATE_FORMAT(checking_date, '%M %Y')"),
                'prs_supplier_id',
                'supplier',
                DB::raw('MONTH(checking_date)')
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
                    'total_received' => $dbItem->qty_receiving,
                    'total_ng' => $dbItem->qty_ng,
                    'total_ppm' => $dbItem->ppm,
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