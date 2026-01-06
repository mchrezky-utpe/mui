<?php

namespace App\Services\Master\Bom;
use App\Models\Master\Bom\VwBomList;
use App\Models\Master\Bom\Bom;
use App\Models\Master\Bom\BomDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\NumberGenerator;


class BomService
{
    public function list_pageable(Request $request){
        
        $start = $request->input('start');
        $length = $request->input('length'); 
        $search = $request->input('search.value');
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
        $columns = $request->input('columns');

        $query = DB::table('vw_app_list_mst_sku_bom');
        
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('vw_app_list_mst_sku_bom.manual_id', 'like', '%' . $search . '%')
                    ->orWhere('vw_app_list_mst_sku_bom.doc_num', 'like', '%' . $search . '%')
                    ->orWhere('vw_app_list_mst_sku_bom.description', 'like', '%' . $search . '%')
                    ->orWhere('vw_app_list_mst_sku_bom.description', 'like', '%' . $search . '%');
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
            $doc_num_generated = NumberGenerator::generateNumberV3('mst_sku_bom', 'BM','counter',5);
            $data = [
                'sku_id' => $request->sku_id,
                'prefix' => $doc_num_generated['doc_num'],
                'counter' => $doc_num_generated['doc_counter'],
                'remark' => $request->description,
                'flag_main_priority' => $request->flag_main_priority == "on" ? 1 : 0,
                'flag_status' => 1,
                'flag_active' => 1,
                'generated_id' => Str::uuid()->toString()
            ];

           // Store Header Data
            $header =   Bom::create($data);

            $bom_id = $header->id;
            $data = json_decode($request->data, true);

            $details = [];
            foreach ($data as $value) {
                $detailData = [
                    'sku_id' => $value['sku_id'],
                    'description' => $value['description'],
                    'qty_capacity' => $value['qty_capacity'],
                    'qty_each_unit' => $value['qty_each_unit'],
                    'sku_bom_id' => $bom_id,
                    'rec_key' => $value['rec_key'],
                    'level' => $value['level'],
                    'rec_parent_key' => $value['rec_parent_key'],
                    'prs_supplier_id' => $value['supplier_id'],
                    'sku_process_type_id' => $value['process_type_id'], 
                    'flag_active' => 1,
                ];
                // Insert new record
                $detailData['generated_id'] = Str::uuid()->toString();
                $details[] = $detailData;
            }

            // Insert records baru sekaligus
            if (!empty($details)) {
                BomDetail::insert($details);
            }

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

    public function get_detail($id)
    {
        $header = VwBomList::where('id', $id)->firstOrFail();
        $details = BomDetail::where("sku_bom_id", $id)->get();
    return (object) [
        "header" => $header,
        "details" => $details
    ];
    }

    public function do_edit_detail($bom_id, $data)
    {
        DB::beginTransaction();

        try {
            // Ambil semua ID yang dikirim (jika ada)
            $submittedIds = collect($data)->pluck('id')->filter()->toArray();

            // Hapus record yang tidak ada dalam data yang dikirim
            BomDetail::where('sku_bom_id', $bom_id)
                    ->when(!empty($submittedIds), function($query) use ($submittedIds) {
                        $query->whereNotIn('id', $submittedIds);
                    })
                    ->delete();

            $details = [];
            foreach ($data as $value) {
                $detailData = [
                    'sku_id' => $value['sku_id'],
                    'description' => $value['description'],
                    'qty_capacity' => $value['qty_capacity'],
                    'qty_each_unit' => $value['qty_each_unit'],
                    'sku_bom_id' => $bom_id,
                    'rec_key' => $value['rec_key'],
                    'level' => $value['level'],
                    'rec_parent_key' => $value['rec_parent_key'],
                    'sku_process_type_id' => $value['process_type_id'], 
                    'flag_active' => 1,
                ];

                if (!empty($value['id'])) {
                    // Update existing record
                    BomDetail::where('id', $value['id'])->update($detailData);
                } else {
                    // Insert new record
                    $detailData['generated_id'] = Str::uuid()->toString();
                    $details[] = $detailData;
                }
            }

            // Insert records baru sekaligus
            if (!empty($details)) {
                BomDetail::insert($details);
            }

            DB::commit();

            return response()->json([
                'message' => 'Data BOM detail berhasil diperbarui',
                'success' => true
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $bom = Bom::where('id', $id)->firstOrFail();
    
            $bom->flag_active = 0;
            $bom->deleted_at = Carbon::now();
            $bom->deleted_by = Auth::id();
            $bom->save();

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

        $header = Bom::where('id', $id)->firstOrFail();
        $details = BomDetail::where("bom_id", $id);
        return array(
            "header" => $header,
            "details" => $details
        );
    } 
    
    function edit(Request $request)
    {
        $data = Bom::where('id', $request->id)->firstOrFail();
        $data->remark = $request->remark;
        $data->sku_id = $request->sku_id;
        $data->save();
    }
}