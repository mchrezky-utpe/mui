<?php

namespace App\Services\Transaction;

use App\Helpers\HelperCustom;
use App\Models\Transaction\SkuPricelist;
use App\Models\Transaction\Pricelist\SkuPricelistVw;
use App\Models\Transaction\Pricelist\SkuPricelistHistoryVw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SkuPricelistService
{
    public function list(){
          return SkuPricelistVw::where('flag_pricelist_status', 1)->get();;
    }

    public function get_by(Request $request){
    //     $query = SkuPricelist::with(['sku'])
    //     ->where('flag_active', 1);
    //     foreach ($request->all() as $field => $value) {
    //         if (!empty($value)) {
    //             $query->where($field, $value);
    //         }
    //     }
    //    return $query->get();

       $query = SkuPricelistVw::where('flag_pricelist_status', 1);
        foreach ($request->all() as $field => $value) {
            if (!empty($value)) {
                $query->where($field, $value);
            }
        }
       return $query->get();
    }

    public function getHistory(Request $request){
        $query = SkuPricelistHistoryVw::where('flag_active', 0)->where('prs_supplier_id', $request->prs_supplier_id)->where('item_id', $request->item_id)->get();
       return $query;
    }

    public function add(Request $request){
            $data = new SkuPricelist();
            $data->sku_id = $request->sku_id;
            $data->prs_supplier_id = $request->prs_supplier_id;
            $data->gen_currency_id = $request->gen_currency_id;
            $data->lead_time = $request->lead_time;
            $data->valid_date_from = $request->valid_date_from;
            $data->valid_date_to = $request->valid_date_to;
            $data->flag_status = $request->flag_status;
            $data->price = $request->price;
            $data->price_retail = $request->price_retail;
            $data->generated_id = Str::uuid()->toString();
            $data->flag_active = 1;
            $data->flag_status= 1;
            $data->flag_type= 1;
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
        // set off old data
        $data->flag_active = 0;
        $data->save();

        // copy new data
        $data = $data->replicate();
        $data->sku_id = $request->sku_id;
        $data->prs_supplier_id = $request->prs_supplier_id;
        $data->gen_currency_id = $request->gen_currency_id;
        $data->lead_time = $request->lead_time;
        $data->valid_date_from = $request->valid_date_from;
        $data->valid_date_to = $request->valid_date_to;
        $data->flag_status = $request->flag_status;
        $data->price = $request->price;
        $data->price_retail = $request->price_retail;
        $data->generated_id = Str::uuid()->toString();
        $data->flag_active = 1;
        $data->flag_status= 1;
        $data->save();
    }
}
