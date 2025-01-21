<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterGeneralOtherCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MasterGeneralOtherCostService
{
    public function list(){
        //   return MasterGeneralOtherCost::all();
          return MasterGeneralOtherCost::where('flag_active', 1)->get();
    }
    public function list2(){
        //   return MasterGeneralOtherCost::all();
          return MasterGeneralOtherCost::where('flag_active', 0)->get();
    }

    public function add(Request $request){
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = MasterGeneralOtherCost::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('GEN-OC-', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = MasterGeneralOtherCost::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    public function hapus($id){
        $data = MasterGeneralOtherCost::where('id', $id)->firstOrFail();
        $data->delete();
    }
    public function restore($id){
        $data = MasterGeneralOtherCost::where('id', $id)->firstOrFail();
        $data->flag_active = 1;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterGeneralOtherCost::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterGeneralOtherCost::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}