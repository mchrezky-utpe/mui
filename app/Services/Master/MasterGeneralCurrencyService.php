<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterGeneralCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MasterGeneralCurrencyService
{
    public function list(){
        //   return MasterGeneralCurrency::all();
          return MasterGeneralCurrency::where('flag_active', 1)->get();
    }
    public function list2(){
        //   return MasterGeneralCurrency::all();
          return MasterGeneralCurrency::where('flag_active', 0)->get();
    }

    public function add(Request $request){
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data['flag_show'] = 1;
            $data = MasterGeneralCurrency::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('GEN-C-', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = MasterGeneralCurrency::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    public function restore($id){
        $data = MasterGeneralCurrency::where('id', $id)->firstOrFail();
        $data->flag_active = 1;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    public function hapus($id){
        $data = MasterGeneralCurrency::where('id', $id)->firstOrFail();
        $data->delete();
    }
    
    public function get(int $id)
    {
        return MasterGeneralCurrency::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterGeneralCurrency::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}