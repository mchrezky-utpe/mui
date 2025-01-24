<?php

namespace App\Services\Transaction;

use App\Helpers\HelperCustom;
use App\Models\Transaction\SkuPricelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SkuPricelistService
{
    public function list(){
          return SkuPricelist::all();
    }

    public function add(Request $request){
            $data['sku_id'] = $request->sku_id;
            $data['gen_currency_id'] = $request->gen_currency_id;
            $data['prs_supplier_id'] = $request->prs_supplier_id;
            $data['price'] = $request->price;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = SkuPricelist::create($data);
            $data->save();
    }

    public function delete($id){
        $data = SkuPricelist::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return SkuPricelist::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = SkuPricelist::where('id', $request->id)->firstOrFail();
        $data->price = $request->price;
        $data->sku_id = $request->sku_id;
        $data->gen_currency_id = $request->gen_currency_id;
        $data->prs_supplier_id = $request->prs_supplier_id;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}