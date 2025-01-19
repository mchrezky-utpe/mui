<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterGeneralExchangeRates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MasterGeneralExchangeRatesService
{
    public function list(){
        //   return MasterGeneralExchangeRates::all();
          return MasterGeneralExchangeRates::where('flag_active', 1)->get();
    }

    public function add(Request $request){
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = MasterGeneralExchangeRates::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('GEN-ER-', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = MasterGeneralExchangeRates::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterGeneralExchangeRates::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterGeneralExchangeRates::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}