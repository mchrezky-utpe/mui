<?php

namespace App\Services\Master\Bom;
use App\Models\Master\Bom\VwBomList;
use App\Models\Master\Bom\Bom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BomService
{
    public function list_pageable(Request $request){
        
        $start = $request->input('start');
        $length = $request->input('length'); 
        $search = $request->input('search.value');
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
        $columns = $request->input('columns');

        $query = DB::table('mst_sku_bom');
        
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('mst_sku_bom.manual_id', 'like', '%' . $search . '%')
                    ->orWhere('mst_sku_bom.doc_num', 'like', '%' . $search . '%')
                    ->orWhere('mst_sku_bom.description', 'like', '%' . $search . '%')
                    ->orWhere('mst_sku_bom.description', 'like', '%' . $search . '%');
            });
        }

        $recordsTotal = $query->count();

        $recordsFiltered = $query->count();

        $data = $query->get();
        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' =>  $recordsFiltered
        ];
    }

    public function add(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $data = [
                'sku_id' => $request->sku_id,
                'remark' => $request->remark,
                'flag_status' => 1,
                'flag_active' => 1,
                'generated_id' => Str::uuid()->toString()
            ];
            Bom::create($data);

            // Commit transaksi jika semua berhasil
            DB::commit();
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat add.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $purchaseOrder = Bom::where('id', $id)->firstOrFail();
    
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
                'message' => 'Terjadi kesalahan saat menghapus.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function get(int $id)
    {
        return Bom::where('id', $id)->firstOrFail();
    } 
    
    function edit(Request $request)
    {
        $data = Bom::where('id', $request->id)->firstOrFail();
        $data->remark = $request->remark;
        $data->sku_id = $request->sku_id;
        $data->save();
    }
}