<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\Master\Sku\MasterSkuType;
use App\Models\Master\Sku\SkuTypeListVw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MasterSkuTypeService
{
    public function list(){
          return SkuTypeListVw::all();
    }

    function convertCheckboxToBoolean($value)
    {
        return $value === 'on';
    }

    public function add(Request $request){
        $data = new MasterSkuType();
        $data->manual_id = $request->manual_id;
        $data->sku_category_id = $request->sku_category_id;
        $data->sku_sub_category_id = $request->sku_sub_category_id;
        $data->description = $request->description;
        $data->prefix = $request->prefix;
        $data->group_tag = $request->group_tag;
        $data->sku_classification_id = $request->sku_classification_id;
        $data->flag_trans_type = $request->flag_trans_type;
        $data->flag_primary = $this->convertCheckboxToBoolean($request->flag_primary);
        $data->flag_checking = $this->convertCheckboxToBoolean($request->flag_checking);
        $data->flag_checking_result = $this->convertCheckboxToBoolean($request->flag_checking_result);
        $data->flag_bom = $this->convertCheckboxToBoolean($request->flag_bom);
        $data->flag_allowance = $request->flag_allowance;
        $data->val_allowance = $request->val_allowance;
        $data->generated_id = Str::uuid()->toString();
        $data->flag_active = 1;
        $data = $data->save();
        // $data->prefix = HelperCustom::generateTrxNo('SKUT', $data->id);
        // $data->save();
    }

    public function delete($id){
        $data = MasterSkuType::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterSkuType::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterSkuType::where('id', $request->id)->firstOrFail();
        $data->manual_id = $request->manual_id;
        $data->sku_category_id = $request->sku_category_id;
        $data->sku_sub_category_id = $request->sku_sub_category_id;
        $data->description = $request->description;
        $data->prefix = $request->prefix;
        $data->group_tag = $request->group_tag;
        $data->sku_classification_id = $request->sku_classification_id;
        $data->flag_trans_type = $request->flag_trans_type;
        $data->flag_primary = $this->convertCheckboxToBoolean($request->flag_primary);
        $data->flag_checking = $this->convertCheckboxToBoolean($request->flag_checking);
        $data->flag_checking_result = $request->flag_checking_result;
        $data->flag_bom = $this->convertCheckboxToBoolean($request->flag_bom);
        $data->flag_allowance = $request->flag_allowance;
        $data->val_allowance = $request->val_allowance;
        $data->generated_id = Str::uuid()->toString();
        $data->flag_active = 1;
        $data = $data->save();
    }

    public function droplist(){
        return SkuTypeListVw::all();
    }
}