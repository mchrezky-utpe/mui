<?php

namespace App\Services\Transaction;

use App\Models\Transaction\ProductionProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionProcessService
{
    public function list(){
        return ProductionProcess::where('flag_active', 1)->get();
    }
    public function list2(){
        return ProductionProcess::where('flag_active', 0)->get();
    }

    /**
     * Add new production record
     */
    public function add(Request $request){
        $data['description'] = $request->description;
        $data['flag_process_classification'] = $request->flag_process_classification;
        $data['flag_checking_input_method'] = $request->flag_checking_input_method;
        $data['flag_item_size_category'] = $request->flag_item_size_category;
        $data['line_part_code'] = $request->line_part_code;
        $data['val_area'] = $request->val_area;
        $data['val_weight'] = $request->val_weight;
        $data['qty_standard'] = $request->qty_standard;
        $data['qty_target'] = $request->qty_target;
        $data['flag_status'] = 1;
        $data['flag_active'] = 1;
        $data= ProductionProcess::create($data);
        $data->save();
    }

    /**
     * Delete production record
     */
    public function delete($id)
    {
        $data = ProductionProcess::where('id',$id)->firstOrFail();
        $data->flag_active = 0;
        $data->save();
    }

    /**
     * Get single production record by ID
     */
    public function get(int $id)
    {
        return ProductionProcess::where('id', $id)->firstOrFail();
    }

    /**
     * Edit production record
     */
    public function edit(Request $request)
    {        
            
        $data =ProductionProcess::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->flag_process_classification = $request->flag_process_classification;
        $data->flag_checking_input_method = $request->flag_checking_input_method;
        $data->flag_item_size_category = $request->flag_item_size_category ?? 0;
        $data->line_part_code = $request->line_part_code ?? 0;
        $data->val_area = $request->val_area ?? 0;
        $data->val_weight = $request->val_weight ?? 0;
        $data->qty_standard = $request->num_masking ?? 0;
        $data->qty_target = $request->num_buffing ?? 0;
        $data->save();
    }
}