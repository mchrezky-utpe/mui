<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterSkuBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Master\Sku\SkuBusinessListVw;

class MasterSkuBusinessService
{
    public function list(){
        return MasterSkuBusiness::where('flag_active', 1)->get();
    }

    public function add(Request $request){
        $data['description'] = $request->description;
        $data['manual_id'] = $request->manual_id;
        $data['generated_id'] = Str::uuid()->toString();
        $data['flag_active'] = 1;
        $data = MasterSkuBusiness::create($data);
        $data['prefix'] = HelperCustom::generateTrxNo('SKUT', $data->id);
        $data->save();
    }

    public function delete($id){
        $data = MasterSkuBusiness::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterSkuBusiness::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterSkuBusiness::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }

    public function droplist(){
        return SkuBusinessListVw::all();
    }
}