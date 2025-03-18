<?php

namespace App\Services\Transaction\Receiving;
use App\Models\Transaction\Receiving\VwReceivingList;
use App\Models\Transaction\Receiving\VwReplacementDroplist;
use App\Models\Transaction\Receiving\TransReceiving;
use App\Models\Transaction\Receiving\TransReceivingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ReplacementService
{
    public function list(){
        return VwReceivingList::where('flag_transaction', 4)->get();
    }

    
    public function get_droplist($request){
        return VwReplacementDroplist::where('prs_supplier_id', $request->input('supplier_id'))->get();
    }


    public function add(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $doc_num = $request->manual_id;
        
            $data = [
                'prs_supplier_id' => $request->prs_supplier_id,
                'trans_date' => $request->trans_date,
                'doc_num' => $doc_num,
                'flag_transaction' => 4,
                // 'doc_counter' => $doc_num_generated['doc_counter'],
                'flag_status' => 1,
                'revision' => 0,
                'flag_active' => 1,
                'generated_id' => Str::uuid()->toString()
            ];
    
            $header = TransReceiving::create($data);
            $items = [];
    
            foreach ($request->detail_id as $index => $detail_id) {
                $items[] = [
                    'qty' => $request->qty[$index],
                    'generated_id' => Str::uuid()->toString(),
                    'trans_rr_id' => $header->id, 
                    'do_detail_id' => $detail_id,
                    'description' => 'REMARK SUPPLY'
                ];
            }
    
            TransReceivingDetail::insert($items);
    
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat receiving.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $purchaseOrder = TransReceiving::where('id', $id)->firstOrFail();
    
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
        return TransReceiving::where('id', $id)->firstOrFail();
    } 
    

    function edit(Request $request)
    {
        $data = TransReceiving::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}