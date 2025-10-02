<?php

namespace App\Services\Transaction\Receiving;
use App\Models\Transaction\Receiving\VwReceivingList;
use App\Models\Transaction\Receiving\VwGpoDroplist;
use App\Models\Transaction\Receiving\TransReceiving;
use App\Models\Transaction\Receiving\TransReceivingDetail;
use App\Models\Transaction\Receiving\VwGpoDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class GpoService
{
    public function list(){
        return VwReceivingList::where('flag_transaction', 2)->get();
    }

    
    public function get_droplist($request){

        return VwGpoDroplist::where('prs_supplier_id', $request->input('supplier_id'))
        ->where('flag_type', $request->input('gpo_type'))->get();
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
                'gpo_type' =>$request->gpo_type,
                'flag_transaction' => 2,
                // 'doc_counter' => $doc_num_generated['doc_counter'],
                'flag_status' => 1,
                'revision' => 0,
                'flag_active' => 1,
                'generated_id' => Str::uuid()->toString()
            ];
    
            $header = TransReceiving::create($data);
            $items = [];

            foreach ($request->po_detail_id as $index => $po_detail_id) {
                $items[] = [
                    'qty' => $request->qty[$index],
                    'generated_id' => Str::uuid()->toString(),
                    'trans_rr_id' => $header->id, 
                    'sku_id' => $po_detail_id,
                    'do_detail_id' => $po_detail_id,
                    'description' => 'REMARK GPO'
                ];
            }
            TransReceivingDetail::insert($items);
    
            // Commit transaksi jika semua berhasil
            DB::commit();
        } catch (\Exception $e) {
            // Rollback jika terjadi error
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

    
    public function detail(int $id)
    {
        return VwGpoDetail::where('trans_rr_id', $id)->get();
    } 
    
    function edit(Request $request)
    {
        $data = TransReceiving::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }

    public function api_all(Request $request){
        $start = $request->input('start'); 
        $length = $request->input('length');
        $search = $request->input('search.value'); 
        $query = DB::table('vw_app_list_trans_rr_gpo_dt');

        if ($request->start_date != null && $request->end_date != null) {
            $query->whereBetween('do_date', [$request->start_date, $request->end_date]);
        }
        
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->Where('do_doc_num', 'like', '%' . $search . '%')
                    ->orWhere('po_doc_num', 'like', '%' . $search . '%')
                    ->orWhere('sku_description', 'like', '%' . $search . '%')
                    ->orWhere('sku_specification_code', 'like', '%' . $search . '%')
                    ->orWhere('gpo_type', 'like', '%' . $search . '%')
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

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' =>  $recordsFiltered
        ];
    }
}