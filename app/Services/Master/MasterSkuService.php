<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterSku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MasterSkuService
{
    public function list(){
          return MasterSku::with(['type','unit','detail','model','process','packaging','business'])
          ->where('flag_active', 1)
          ->get();
    }

    public function add(Request $request){
            $data['description'] = $request->description;
            $data['flag_active'] = 1;
            $data['flag_show'] = 1;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['sku_type_id'] = $request->type_id;
            $data['sku_unit_id'] = $request->unit_id;
            $data['sku_model_id'] = $request->model_id;
            $data['sku_process_id'] = $request->process_id;
            $data['sku_business_type_id'] = $request->business_type_id;
            $data['sku_packaging_id'] = $request->packaging_id;
            $data['sku_detail_id'] = $request->detail_id;
            $data = MasterSku::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('SKU', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = MasterSku::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterSku::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterSku::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->sku_type_id = $request->sku_type_id;
        $data->sku_unit_id = $request->sku_unit_id;
        $data->sku_model_id = $request->sku_model_id;
        $data->sku_process_id = $request->sku_process_id;
        $data->sku_business_type_id = $request->sku_business_type_id;
        $data->sku_packaging_id = $request->sku_packaging_id;
        $data->sku_detail_id = $request->sku_detail_id;
        $data->manual_id= $request->manual_id;
        $data->save();
    }

}