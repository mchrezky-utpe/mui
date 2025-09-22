<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterGeneralExchangeRates;
use App\Models\VwMasterGeneralExchangeRates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MasterGeneralExchangeRatesService
{
    public function list(){
        //   return MasterGeneralExchangeRates::all();
          return VwMasterGeneralExchangeRates::all();
    }
    public function list2(){
        //   return MasterGeneralExchangeRates::all();
          return MasterGeneralExchangeRates::where('flag_active', 0)->get();
    }

    public function add(Request $request){
            $data['valid_from_date'] = $request->date;
            $data['gen_currency_id'] = $request->gen_currency_id;
            $data['val_exchangerates'] = $request->val_exchangerates;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = MasterGeneralExchangeRates::create($data);
            $data->save();
    }

    public function delete($id){
        $data = MasterGeneralExchangeRates::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    public function restore($id){
        $data = MasterGeneralExchangeRates::where('id', $id)->firstOrFail();
        $data->flag_active = 1;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }

    public function hapus($id){
        $data = MasterGeneralExchangeRates::where('id', $id)->firstOrFail();
        $data->delete();
    }
    
    public function get(int $id)
    {
        return MasterGeneralExchangeRates::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterGeneralExchangeRates::where('id', $request->id)->firstOrFail();
        $data->valid_from_date = $request->date;
        $data->val_exchangerates= $request->val_exchangerates;
        $data->save();
    }
}