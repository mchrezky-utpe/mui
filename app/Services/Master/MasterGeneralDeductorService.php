<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterGeneralDeductor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MasterGeneralDeductorService
{
    public function list(){
        //   return MasterGeneralDeductor::all();
          return MasterGeneralDeductor::where('flag_active', 1)->get();
    }

    public function add(Request $request){
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = MasterGeneralDeductor::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('GEN-DE-', $data->id);
            $data['app_module_id'] = $request->app_module_id;
            $data->save();
    }

    public function delete($id){
        $data = MasterGeneralDeductor::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterGeneralDeductor::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterGeneralDeductor::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->app_module_id= $request->app_module_id;
        $data->save();
    }
}