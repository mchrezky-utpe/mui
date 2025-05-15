<?php

namespace App\Services\Transaction;

use App\Models\Transaction\ProductionCycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionService
{
    public function list(){
        return ProductionCycle::where('flag_active', 1)->get();
    }
    public function list2(){
        return ProductionCycle::where('flag_active', 0)->get();
    }

    /**
     * Add new production record
     */
    public function add(Request $request){
        $data['description'] = $request->description;
        $data['num_jigging'] = $request->num_jigging;
        $data['num_lineprocess'] = $request->num_lineprocess;
        $data['num_unjigging'] = $request->num_unjigging;
        $data['num_inspection'] = $request->num_inspection;
        $data['num_assembly'] = $request->num_assembly;
        $data['num_cutting'] = $request->num_cutting;
        $data['num_masking'] = $request->num_masking;
        $data['num_buffing'] = $request->num_buffing;
        $data['flag_active'] = 1;
        // $data['num_total'] = $this->calculateTotal($request);
        $data= ProductionCycle::create($data);
        $data->save();
    }

    /**
     * Delete production record
     */
    public function delete($id)
    {
        $data = ProductionCycle::where('id',$id)->firstOrFail();
        $data->flag_active = 0;
        $data->save();
    }

    /**
     * Get single production record by ID
     */
    public function get(int $id)
    {
        return ProductionCycle::where('id', $id)->firstOrFail();
    }

    /**
     * Edit production record
     */
    public function edit(Request $request)
    {        
            
        $data =ProductionCycle::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->num_jigging = $request->num_jigging ?? 0;
        $data->num_lineprocess = $request->num_lineprocess ?? 0;
        $data->num_unjigging = $request->num_unjigging ?? 0;
        $data->num_inspection = $request->num_inspection ?? 0;
        $data->num_assembly = $request->num_assembly ?? 0;
        $data->num_cutting = $request->num_cutting ?? 0;
        $data->num_masking = $request->num_masking ?? 0;
        $data->num_buffing = $request->num_buffing ?? 0;
        
        $data->save();
    }
}