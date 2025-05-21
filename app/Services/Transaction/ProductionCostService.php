<?php

namespace App\Services\Transaction;

use App\Models\Transaction\ProductionCost;
use App\Models\Transaction\ProductionCostDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionCostService
{
    public function list(){
        return ProductionCost::all();
    }
    
    /**
     * Active Deactive
     */
    public function active_deactive(Request $request)
    {
        DB::beginTransaction();
        try {

            DB::statement('CALL  sp_trans_prod_cost_update_status(?)',
             [$request->flag_active]);
          
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat Purchase Order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Add new production record
     */
    public function add(Request $request){
        $data['sku_name'] = $request->sku_name;
        $data['sku_model'] = $request->sku_model;
        $data['flag_status'] = 1;
        $data['flag_active'] = 1;
        $data= ProductionCost::create($data);
        $data->save();
    }

    /**
     * Delete production record
     */
    public function delete($id)
    {
        $data = ProductionCost::where('id',$id)->firstOrFail();
        $data->flag_active = 0;
        $data->save();
    }

    /**
     * Get single production record by ID
     */
    public function get(int $id)
    {
        return ProductionCostDetail::where('id', $id)->firstOrFail();
    }

    /**
     * Edit production record
     */
    public function edit(Request $request)
    {        
            
        $data =ProductionCost::where('id', $request->id)->firstOrFail();
        $data->sku_name = $request->sku_name;
        $data->sku_model = $request->sku_model;
        $data->save();
    }
}