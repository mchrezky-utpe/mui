<?php

namespace App\Services\Transaction;
use App\Models\Transaction\VwSdoList;
use App\Models\Transaction\Receiving\VwSdoDetail;
use App\Models\Transaction\VwSdoDroplist;
use App\Models\Transaction\VwSdoItemList;
use App\Models\Transaction\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Transaction\PurchaseOrdePrintDtVw;
use App\Models\Transaction\PurchaseOrdePrintHdVw;
use Illuminate\Support\Facades\DB;


class SdoService
{
    public function list(){
        return VwSdoItemList::where('flag_transaction', 1)->get();
    }
    
   public function get_all(Request $request){
        $start = $request->input('start');
        $length = $request->input('length'); 
        $search = $request->input('search.value');
        $query = DB::table('vw_app_pick_trans_do_dt');

        if ($request->start_date != null && $request->end_date != null) {
            $query->whereBetween('trans_date', [$request->start_date, $request->end_date]);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->Where('do_doc_num', 'like', '%' . $search . '%')
                    ->orWhere('po_doc_num', 'like', '%' . $search . '%')
                    ->orWhere('sds_doc_num', 'like', '%' . $search . '%')
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
    
    public function get_droplist($request){
        return VwSdoDroplist::where('prs_supplier_id', $request->input('supplier_id'))->get();
    }
    
    public function get_item(Request $request){
        return VwSdoItemList::where('trans_do_id', $request->input('id'))->get();
     }
        
    public function receive(Request $request){
        DB::beginTransaction();
        try {
            $userId =  Auth::id();

            foreach ($request->detail_id as $index => $do_detail_id) {
                DB::statement('CALL sp_trans_rr_import_do(?,?,?,?,?,?,?)',
                 [$request->trans_date,$request->prs_supplier_id, $request->detail_id[$index], "REMARK", $userId, $request->qty[$index], 1]);
            }
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
        return VwSdoDetail::where('trans_rr_id', $id)->get();
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