<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterSkuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MasterSkuModelService
{
    public function list(){
          return MasterSkuModel::all();
    }

    public function add(Request $request){
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['image_path'] = 'tes'; // TODO IMPLEMENT UPLOAD
            $data['flag_active'] = 1;
            $data = MasterSkuModel::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('SKUM', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = MasterSkuModel::where('id', $id)->firstOrFail();
        $data->delete();
    }
    
    public function get(int $id)
    {
        return MasterSkuModel::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterSkuModel::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->image_path = $request->image_path; // TODO UPLOAD
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}