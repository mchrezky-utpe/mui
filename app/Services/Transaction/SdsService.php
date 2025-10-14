<?php

namespace App\Services\Transaction;
use App\Helpers\NumberGenerator;

use App\Models\Transaction\VwSdsList;
use App\Models\Transaction\VwSdsDetail;
use App\Models\Transaction\Sds;
use App\Models\Transaction\SdsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SdsService
{
    public function list(){
        return VwSdsList::orderBy('created_at', 'DESC')->get();
    }
    
   public function get_all(Request $request){
        $start = $request->input('start');
        $length = $request->input('length'); 
        $search = $request->input('search.value');
        $query = DB::table('vw_app_list_trans_sds_hd');

        if ($request->start_date != null && $request->end_date != null) {
            $query->whereBetween('trans_date', [$request->start_date, $request->end_date]);
        }

        if ($request->flag_status != null) {
            $query->where('flag_status','=', $request->flag_status );
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

        return [
            'data' => $processedData,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    public function getPoDroplist(Request $request){
        $query = DB::table('vw_app_pick_trans_po_for_sds_hd');
        if ($request->input('supplier_id') != null) {
        $query->where('prs_supplier_id', [$request->input('supplier_id')]);
        }

        return $query->get();
    }

    public function send_to_edi(Request $request){
            DB::beginTransaction();
            try {
                $userId =  Auth::id();
                DB::statement('CALL sp_trans_sds_sent_edi(?,?)',
                 [$request->id, $userId]);
              
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                return response()->json([
                    'message' => 'Terjadi kesalahan saat kirim ke EDI.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        
    public function reschedule(Request $request){
        DB::beginTransaction();
        try {
            $userId =  Auth::id();
            $doc_num_generated = NumberGenerator::generateNumber('trans_supplier_delivery_schedule', 'SDS');

            $code = $request->doc_number_old;   
            $parts = explode("/", $code);
            $rev_code = (int)$parts[3];

            DB::statement('CALL sp_trans_sds_reschedule(?,?,?,?,?,?)',
             [$request->id,$doc_num_generated['doc_num'], $doc_num_generated['doc_counter'], $rev_code,$request->date,$userId]);
          
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat kirim ke EDI.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

   public function pull_back(Request $request){
    DB::beginTransaction();
    try {
        $userId = Auth::id();
        $sds = Sds::findOrFail($request->id);
        $sds->update(['flag_status' => 3]);
        DB::commit();
        return response()->json(['message' => 'Berhasil pull back SDS']);
    } catch (\Exception $e) {
        DB::rollBack();
        report($e);
        return response()->json([
            'message' => 'Terjadi kesalahan.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function add(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // Generate nomor dokumen
            $doc_num_generated = NumberGenerator::generateNumber('trans_supplier_delivery_schedule', 'SDS');
          
            // SDS Header Data
            $data = [
                'trans_po_id' => $request->trans_po_id,
                'prs_supplier_id' => $request->prs_supplier_id,
                'trans_date' => $request->trans_date,
                'doc_num' => $doc_num_generated['doc_num'],
                'doc_counter' => $doc_num_generated['doc_counter'],
                'flag_status' => 1,
                'revision' => 0,
                'flag_active' => 1,
                'generated_id' => Str::uuid()->toString()
            ];
    
            // Simpan data PO Header
            $sdsHeader = Sds::create($data);
            $items = [];
    
            // SDS Detail Data
            foreach ($request->po_detail_id as $index => $po_detail_id) {
                $items[] = [
                    'qty' => $request->qty[$index],
                    'generated_id' => Str::uuid()->toString(),
                    'trans_sds_id' => $sdsHeader->id, 
                    'po_detail_id' => $po_detail_id
                ];
            }
    
            // Simpan data PO Detail
            SdsDetail::insert($items);
    
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat sds.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $sds = Sds::where('id', $id)->firstOrFail();
    
            $sds->flag_active = 0;
            $sds->deleted_at = Carbon::now();
            $sds->deleted_by = Auth::id();
            $sds->save();

            DB::commit();
    
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus SDS.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function get(int $id)
    {
        $data =   Sds::where('id', $id)->firstOrFail();
       $data->items =  SdsDetail::where('trans_sds_id', $id)->get();
       return $data;
    } 
    
    public function detail(int $id)
    {
       $header =  VwSdsList::where('id', $id)->firstOrFail();
       $details = VwSdsDetail::where('trans_sds_id', $id)->get();
        return [
            'header' => $header,
            'details' => $details,
        ];
    } 

   public function edit(Request $request)
    {
        DB::beginTransaction();

        try {
            $sdsHeader = Sds::where('id', $request->id)->firstOrFail();

            if ($sdsHeader->flag_status != 2) {
                return response()->json([
                    'message' => 'SDS tidak dapat diedit karena status sudah diproses lebih lanjut.',
                ], 400);
            }

            $sdsHeader->update([
                'trans_po_id' => $request->trans_po_id,
                'prs_supplier_id' => $request->prs_supplier_id,
                'trans_date' => $request->trans_date
            ]);

            SdsDetail::where('trans_sds_id', $sdsHeader->id)->delete();

            $items = [];

            foreach ($request->po_detail_id as $index => $po_detail_id) {
                $items[] = [
                    'qty' => $request->qty[$index],
                    'generated_id' => Str::uuid()->toString(),
                    'trans_sds_id' => $sdsHeader->id, 
                    'po_detail_id' => $po_detail_id
                ];
            }

            SdsDetail::insert($items);

            DB::commit();

            return response()->json([
                'message' => 'SDS berhasil diupdate.',
                'data' => $sdsHeader
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengupdate sds.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}