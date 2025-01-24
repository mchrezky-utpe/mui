<?php

namespace App\Services\Transaction;

use App\Helpers\HelperCustom;
use App\Models\Transaction\SkuMinOfQty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SkuMinOfQtyService
{
    public function list(){
          return SkuMinOfQty::all();
    }

    public function add(Request $request){
            $data['sku_id'] = $request->sku_id;
            $data['qty'] = $request->qty;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = SkuMinOfQty::create($data);
            $data->save();
    }

    public function delete($id){
        $data = SkuMinOfQty::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return SkuMinOfQty::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = SkuMinOfQty::where('id', $request->id)->firstOrFail();
        $data->sku_id = $request->sku_id;
        $data->qty = $request->qty;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}