<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseInvoiceExport;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NumberGenerator;
use Carbon\Carbon;
use App\Models\Transaction\PurchaseInvoice;
use App\Models\Transaction\PurchaseInvoiceDetail;
use App\Models\Transaction\PurchaseInvoiceOrderDetail;
use Illuminate\Support\Str;

class PurchaseInvoiceController
{

    public function index(): Response
    {
        return response()->view('transaction.pi.index');
    }

    public function index_detail(): Response
    {
        return response()->view('transaction.pi.index_detail');
    }

    public function get_all(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length'); 
        $search = $request->input('search.value');
        $query = DB::table('vw_app_list_trans_pi_hd');

        if ($request->start_date != null && $request->end_date != null) {
            $query->whereBetween('trans_date', [$request->start_date, $request->end_date]);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->Where('doc_num', 'like', '%' . $search . '%')
                    ->orWhere('department', 'like', '%' . $search . '%')
                    ->orWhere('supplier', 'like', '%' . $search . '%');
            });
        }

        $recordsTotal = $query->count();
        $recordsFiltered = $query->count();
        
        if($length > 0){        
            $data = $query->limit($length)->offset($start)->get();
        }else{
            $data = $query->get();
        }

        // Convert data to array dan handle UTF-8 encoding
        $processedData = $data->map(function ($item) {
            $itemArray = (array)$item;
            
            // Encode binary fields to base64
            foreach ($itemArray as $key => $value) {
                if (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
                    $itemArray[$key] = base64_encode($value);
                    $itemArray['_encoding'] = $itemArray['_encoding'] ?? [];
                    $itemArray['_encoding'][$key] = 'base64';
                }
            }
            
            return $itemArray;
        });

        $data = [
            'data' => $processedData,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];

        return response()->json([
            'draw' => intval($request->input('draw')), // Parameter dari DataTables
            'recordsTotal' => $data['recordsTotal'], // Total record tanpa filter
            'recordsFiltered' => $data['recordsFiltered'], // Total record setelah filter
            'data' => $data['data'], // Data untuk ditampilkan
        ]);
    }

    public function get_detail_all(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length'); 
        $search = $request->input('search.value');
        $query = DB::table('vw_app_list_trans_pi_dt');

        if ($request->start_date != null && $request->end_date != null) {
            $query->whereBetween('trans_date', [$request->start_date, $request->end_date]);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->Where('doc_num', 'like', '%' . $search . '%')
                    ->orWhere('department', 'like', '%' . $search . '%')
                    ->orWhere('supplier', 'like', '%' . $search . '%');
            });
        }

        $recordsTotal = $query->count();
        $recordsFiltered = $query->count();
        
        if ($length > 0){        
            $data = $query->limit($length)->offset($start)->get();
        }
        else{
            $data = $query->get();
        }

        $processedData = $data->map(function ($item) {
            $itemArray = (array)$item;
            
            foreach ($itemArray as $key => $value) {
                if (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
                    $itemArray[$key] = base64_encode($value);
                    $itemArray['_encoding'] = $itemArray['_encoding'] ?? [];
                    $itemArray['_encoding'][$key] = 'base64';
                }
            }
            
            return $itemArray;
        });

        $data = [
            'data' => $processedData,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];

        return response()->json([
            'draw' => intval($request->input('draw')), // Parameter dari DataTables
            'recordsTotal' => $data['recordsTotal'], // Total record tanpa filter
            'recordsFiltered' => $data['recordsFiltered'], // Total record setelah filter
            'data' => $data['data'], // Data untuk ditampilkan
        ]);
    }
    
    public function get_po_by(Request $request)
    {
        $query = DB::table('vw_app_pick_trans_po_for_pi_hd');
        
        $query->where('prs_supplier_id', $request->input('prs_supplier_id'));
        $query->where('gen_department_id', $request->input('gen_department_id'));
        
        $carbonDate = Carbon::parse($request->input('trans_date'));
        $month = $carbonDate->month;
        $year = $carbonDate->year;
        $query->whereMonth('trans_date', $month);
        $query->whereYear('trans_date', $year);

        $data = $query->get();

        $uniqueData = $data->unique('po_doc_num')->map(function ($item) {
            return [
                'trans_po_id' => $item->trans_po_id,
                'po_doc_num' => $item->po_doc_num
            ];
        })->values();

        return response()->json([
            'data' => $uniqueData
        ]);
    }
    
    public function get_detail_pi(Request $request, $id)
    {
    $query = DB::table('vw_app_list_trans_pi_dt');
        
        $query->where('trans_pi_id', $id);
    
        $data = $query->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function add(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $doc_num_generated = NumberGenerator::generateNumber('trans_purchase_invoice', 'PI');
            $exchangerates = $request->val_exchangerates ?? 1;
            // Header Data
            $data = [
                'trans_date' => $request->trans_date,
                'description' => $request->description,
                'doc_num' => $doc_num_generated['doc_num'],
                'doc_counter' => $doc_num_generated['doc_counter'],
                'manual_id' => $request->manual_id,
                'flag_type' => $request->flag_type,
                'flag_approval' => $request->flag_approval,
                'prs_supplier_id' => $request->prs_supplier_id,
                'gen_department_id' => $request->gen_department_id,
                'gen_terms_detail_id' => $request->gen_terms_detail_id,
                'flag_phase' => $request->flag_phase,
                'flag_phase_payment' => $request->flag_phase_payment,
                'gen_currency_id' => $request->gen_currency_id,
                'val_exchangerates' =>  $exchangerates ,
                'vat_d' => $request->val_vat * $exchangerates,
                'vat_f' => $request->val_vat ?? 0,
                'vat_percentage' => $request->vat_percentage,
                'subtotal_d' => $request->val_subtotal * $exchangerates,
                'subtotal_f' => $request->val_subtotal,
                'pph23_d' => $request->val_pph23 * $exchangerates,
                'pph23_f' => $request->val_pph23 ?? 0,
                'discount_d' => $request->va_discount  * $exchangerates,
                'discount_f' => $request->va_discount ?? 0,
                'total_d' => $request->val_total * $exchangerates,
                'total_f' => $request->val_total,
                'generated_id' => Str::uuid()->toString(),
                'flag_active' => 1
            ];
    
            // Simpan data PO Header
            $header = PurchaseInvoice::create($data);
            $items;
    
            $userId = Auth::id();
            $now = Carbon::now();

            foreach ($request->trans_po_id as $index => $po_id) {
                $items[] = [
                    'trans_pi_id' => $header->id,
                    'trans_po_id' => $po_id,
                    'generated_id' => Str::uuid()->toString(),
                    'created_by' => $userId,
                    'created_at' => $now,
                    'flag_active' => 1
                ];
            }
    
            PurchaseInvoiceDetail::insert($items);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return redirect("/pi");
    }

    public function get_item_check(Request $request, int $id){
        
        $query = DB::table('vw_app_list_trans_pi_check_dt');
        
        $query->where('id', $id);

        $data = $query->orderBy('doc_num')->orderBy('sku_prefix')->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function verify(Request $request)
    {

        DB::beginTransaction();
        try {
            $userId = Auth::id();
            $now = Carbon::now();

            // Ambil semua data existing berdasarkan trans_pi_id
            $existingItems = PurchaseInvoiceOrderDetail::where('trans_pi_id', $request->trans_pi_id)
                ->get()
                ->keyBy(function($item) {
                    return $item->trans_po_id . '_' . $item->trans_do_detail_id;
                });

            $itemsToInsert = [];
            $itemsToUpdate = [];
            $processedKeys = [];
            // Proses data dari request
            foreach ($request->trans_do_detail_id as $index => $do_detail_id) {
                $is_checked = $request->is_check[$index] ?? "off";
                $key = $request->trans_po_id[$index] . '_' . $do_detail_id;

                // Cek apakah item sudah ada
                if (isset($existingItems[$key]) && $is_checked == "on") {
                    $processedKeys[] = $key;
                    // Update existing item
                    $itemsToUpdate[] = [
                        'id' => $existingItems[$key]->id,
                        'updated_by' => $userId,
                        'updated_at' => $now
                        // Tambahkan field lain yang perlu diupdate
                    ];
                } else if($is_checked == "on") {
                    $processedKeys[] = $key;
                    // Insert new item
                    $itemsToInsert[] = [
                        'trans_pi_id' => $request->trans_pi_id,
                        'trans_po_id' => $request->trans_po_id[$index],
                        'trans_po_detail_id' => $request->trans_po_detail_id[$index],
                        'trans_do_detail_id' => $do_detail_id,
                        'generated_id' => Str::uuid()->toString(),
                        'created_by' => $userId,
                        'created_at' => $now
                    ];
                }
            }


            $itemsToDelete = $existingItems->filter(function($item) use ($processedKeys) {
                $key = $item->trans_po_id . '_' . $item->trans_do_detail_id;
                return !in_array($key, $processedKeys);
            });

            if (!empty($itemsToInsert)) {
                PurchaseInvoiceOrderDetail::insert($itemsToInsert);
            }

            if (!empty($itemsToUpdate)) {
                foreach ($itemsToUpdate as $item) {
                    PurchaseInvoiceOrderDetail::where('id', $item['id'])
                        ->update([
                            'updated_by' => $item['updated_by'],
                            'updated_at' => $item['updated_at']
                        ]);
                }
            }

            if ($itemsToDelete->isNotEmpty()) {
                PurchaseInvoiceOrderDetail::whereIn('id', $itemsToDelete->pluck('id'))
                    ->delete();
            }

            DB::commit();
            
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            // Lebih baik menggunakan log daripada dd di production
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses data.');
        }
        
        return redirect("/pi")->with('success', 'Data berhasil diproses.');
    }

    public function receipt(Request $request,$id,$phase)
    {
        DB::beginTransaction();
        try {
            $userId =  Auth::id();

            DB::statement('CALL sp_trans_pi_receipt(?,?,?)', [$id, $phase, $userId]);
        
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Error PI recepit.',
                'error' => $e->getMessage(),
            ], 500);
        }
        return redirect("/pi");
    }

    public function rollback(Request $request,$id,$phase)
    {
        DB::beginTransaction();
        try {
            $userId =  Auth::id();

              
            DB::statement('CALL sp_trans_pi_rollback(?,?,?)', [$id, $phase, $userId]);
        
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Error PI rollback.',
                'error' => $e->getMessage(),
            ], 500);
        }
        return redirect("/pi");
    }

    public function edit(Request $request)
    {
        $exchangerates = $request->val_exchangerates ?? 1;
        $data = PurchaseInvoice::where('id', $request->id)->firstOrFail();
        $data->manual_id = $request->manual_id;
        $data->gen_terms_detail_id = $request->gen_terms_detail_id;
        $data->flag_phase_payment = $request->flag_phase_payment;
        $data->gen_currency_id = $request->gen_currency_id;
        $data->subtotal_d = $request->val_subtotal * $exchangerates;
        $data->subtotal_f = $request->val_subtotal;
        $data->vat_d = $request->val_vat * $exchangerates;
        $data->vat_f = $request->val_vat;
        $data->discount_d = $request->val_discount * $exchangerates;
        $data->discount_f = $request->val_discount;
        $data->pph23_d = $request->val_pph23 * $exchangerates;
        $data->pph23_f = $request->val_pph23;
        $data->total_d = $request->val_total * $exchangerates;
        $data->total_f = $request->val_total;
        $data->save();
        return redirect("/pi");
    }

    public function delete(Request $request, int $id)
    {
        DB::beginTransaction();

        try {
            $data = PurchaseInvoice::where('id', $id)->firstOrFail();

            $data->flag_active = 0;
            $data->deleted_at = Carbon::now();
            $data->deleted_by = Auth::id();
            $data->save();

            DB::commit();

        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus.',
                'error' => $e->getMessage(),
            ], 500);
        }
        return redirect("/pi");
    }
    
    public function get(Request $request, int $id)
    {
        $query = DB::table('trans_purchase_invoice');
        $query->where('id', [$id]);

        $data = $query->first();
        return response()->json([
            'data' => $data
        ]);
    }

    public function export()
    {
        
       
        // Ambil data dari database
        $query_headers = DB::table('vw_app_list_trans_pi_hd');
        $data_headers = $query_headers->get();
        
        $query_details = DB::table('vw_app_list_trans_pi_dt');
        $data_details = $query_details->get();

        // Mapping data ke format yang diperlukan
        $invoices = $this->mapInvoiceData($data_headers, $data_details);

        return Excel::download(new PurchaseInvoiceExport($invoices), 'purchase_invoice.xlsx');
    }

     private function mapInvoiceData($headers, $details)
    {
        $invoices = [];

        foreach ($headers as $header) {
            // Cari detail items berdasarkan invoice_id atau kolom penghubung
            $invoiceDetails = $details->where('trans_pi_id', $header->id); // Sesuaikan dengan kolom penghubung
            
            $items = [];
            foreach ($invoiceDetails as $detail) {
                $items[] = [
                    'date' => $detail->date ?? $header->trans_date, // Gunakan header date jika detail tidak ada
                    'po_number' => $detail->po_doc_num ?? '',
                    'do_number' => $detail->do_doc_num ?? '',
                    'item_code' => $detail->sku_prefix ?? '',
                    'item_name' => $detail->sku_name ?? '',
                    'item_type' => $detail->sku_material_type ?? '',
                    'unit' => $detail->sku_material_type ?? '',
                    'quantity' => $detail->qty ?? 0,
                    'currency' => $detail->currency ?? $header->currency,
                    'price' => $detail->price_f ?? 0,
                    'amount' => $detail->price_f ?? 0,
                    'checked' => TRUE
                ];
            }

            $invoices[] = [
                'invoice_date' => $header->trans_date ?? '',
                'invoice_code' => $header->doc_num ?? '',
                'invoice_number' => $header->manual_id ?? '',
                'department' => $header->department ?? '',
                'supplier' => $header->supplier ?? '',
                'invoice_type' => $header->invoice_type ?? '',
                'invoice_phase' => $header->invoice_phase ?? '',
                'top' => $header->terms ?? '',
                'approval_required' => $header->approval_required ?? 'NO',
                'currency' => $header->currency ?? 'IDR',
                'sub_total' => $header->val_sub_total ?? 0,
                'discount' => $header->val_discount ?? 0,
                'ppn' => $header->val_vat ?? 0,
                'pph' => $header->val_pph23 ?? 0,
                'total' => $header->val_total ?? 0,
                'phase1_receipt_date' => $header->receipt_date1 ?? '',
                'phase1_recipient' => $header->recipent1 ?? '',
                'phase1_receipt_status' => $header->receipt_status1 ?? '',
                'phase2_receipt_date' => $header->receipt_date2 ?? '',
                'phase2_recipient' => $header->recipent2 ?? '',
                'phase2_receipt_status' => $header->receipt_status2 ?? '',
                'phase3_receipt_date' => $header->receipt_date3 ?? '',
                'phase3_recipient' => $header->recipent3 ?? '',
                'phase3_receipt_status' => $header->receipt_status3 ?? '',
                'approval_date' => $header->approval_date ?? '',
                'approval_status' => $header->approval_status ?? '',
                'items' => $items
            ];
        }

        return $invoices;
    }

}
