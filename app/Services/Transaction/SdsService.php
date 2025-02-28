<?php

namespace App\Services\Transaction;
use App\Helpers\NumberGenerator;

use App\Helpers\HelperCustom;
use App\Models\Transaction\VwSdsList;
use App\Models\Transaction\Sds;
use App\Models\Transaction\SdsDetail;
use App\Models\Transaction\PurchaseOrder;
use App\Models\Transaction\PurchaseOrderDetail;
use App\Models\Transaction\PurchaseOrderDeduction;
use App\Models\Transaction\PurchaseOrderOtherCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Helpers\CalcHelper;
use App\Models\Transaction\PurchaseOrdePrintDtVw;
use App\Models\Transaction\PurchaseOrdePrintHdVw;
use Illuminate\Support\Facades\DB;


class SdsService
{
    public function list(){
          return VwSdsList::get();
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
            $userId =  Auth::id();
            $sds = Sds::where('id', $request->id)->firstOrFail();
    
            $sds->flag_status = 3;
            $sds->save();

            // DB::statement('CALL sp_log_sds_status(?,?,?)',
            // [$request->id,3,$userId]);
         

            DB::commit();
    
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            dd($e);
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
            $items;
    
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
    
            // Commit transaksi jika semua berhasil
            DB::commit();
        } catch (\Exception $e) {
            // Rollback jika terjadi error
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
            $purchaseOrder = PurchaseOrder::where('id', $id)->firstOrFail();
    
            $purchaseOrder->flag_active = 0;
            $purchaseOrder->deleted_at = Carbon::now();
            $purchaseOrder->deleted_by = Auth::id();
            $purchaseOrder->save();

            DB::commit();
    
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus Purchase Order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function get(int $id)
    {
        return PurchaseOrder::where('id', $id)->firstOrFail();
    } 
    public function print(int $id)
    {
        $header = PurchaseOrdePrintHdVw::where('id', $id)->first();
        $detail = PurchaseOrdePrintDtVw::where('trans_po_id', $id)->get();
        
        return [
            'header' => $header,
            'detail' => $detail,
        ];
    } 

    function edit(Request $request)
    {
        $data = PurchaseOrder::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}