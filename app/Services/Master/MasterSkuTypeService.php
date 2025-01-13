<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterSkuType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MasterSkuTypeService
{
    public function list(){
          return MasterSkuType::all();
    }

    public function add(Request $request){
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = MasterSkuType::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('SKUT', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = MasterSkuType::where('id', $id)->firstOrFail();
        $data->delete();
    }
    
    public function get(int $id)
    {
        return MasterSkuType::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterSkuType::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}