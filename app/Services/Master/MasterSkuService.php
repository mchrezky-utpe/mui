<?php

namespace App\Services\Master;

use App\Models\MasterSku;
use App\Models\Master\Sku\MasterSkuType;
use App\Models\Master\Sku\SkuListVw;
use App\Models\Master\Sku\VwExportMasterSku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterSkuService 
{

    function convertCheckboxToBoolean($value)
    {
        return $value === 'on';
    }

    public function list_part_information($limit = 1000){
          return MasterSku::query('flag_sku_type', 1)->orderBy('created_at', 'DESC')->take($limit)->get();
     }

    public function list_production_material_information(){
          return MasterSku::where('flag_sku_type', 2)->orderBy('created_at', 'DESC')->take(1000)->get();
     }

    public function list_general_information(){
          return VwExportMasterSku::where('flag_sku_type', 3)->orderBy('created_at', 'DESC')->take(1000)->get();
     }

    public function get_all_sku(){
          return VwExportMasterSku::orderBy('created_at', 'DESC')->take(1000)->get();
     }
     
    // public function list2(){
    //       return SkuListVw::where('flag_sku_type', 2)->take(50)->get();
    // }
    // // public function list3(){
    // //       return SkuListVw::where('flag_sku_type', 3)->take(50)->get();
    // // }

    public function get_set_code(){
     $type = 2;
      $result = DB::selectOne(" SELECT generate_sku_set_code(2) as set_code ");
      $code = $result->set_code;
      $parts = explode("-", $code);
      $counter = (int)$parts[1];
      return  array(
        'code' => $code,
        'counter' => $counter
      );
    }


    public function generateCode($sku_type_id, $flag_sku_type){
        $prefix = "";
        switch($flag_sku_type){
            case 1:
                $prefix = 'PC';
                breaK;
            case 2:
                $prefix = 'MC';
                break;
            default:
                $prefix = 'IC';
        }

      $result = DB::selectOne(" SELECT generate_sku(?, ?, ?) AS sku ", [$prefix, $flag_sku_type, $sku_type_id]);

      $code = $result->sku;
      $parts = explode("-", $code);
      $counter = (int)$parts[1];
      return  array(
        'code' => $code,
        'counter' => $counter
      );
    }

    public function add(Request $request){

            $sku_type_id = $request->sku_type_id;
            $result_code =  $this->generateCode($sku_type_id,$request->flag_sku_type);

            $data = new MasterSku();

            $data->manual_id = $result_code['code'];
            $data->counter = $result_code['counter'];

            $data->group_tag = $request->group_tag;
            $data->set_code_counter = $request->set_code_counter;

            $data->flag_sku_type = $request->flag_sku_type;
            $data->description = $request->description;
            $data->group_tag = $request->group_tag;
            $data->specification_code = $request->specification_code;
            $data->specification_detail = $request->specification_detail;

            $data->sku_sales_category_id = $request->sku_sales_category_id;
            $data->sku_business_type_id = $request->sku_business_type_id;
            $data->val_weight = $request->val_weight;
            $data->val_area = $request->val_area;
            $data->sku_model_id = $request->sku_model_id;

            $data->sku_inventory_unit_id = $request->sku_inventory_unit_id;
            $data->val_conversion = $request->val_conversion;
            $data->flag_inventory_register = $this->convertCheckboxToBoolean($request->flag_inventory_register);
            $data->sku_type_id = $sku_type_id;
            $data->flag_sku_procurement_type = $request->flag_sku_procurement_type;
            $data->sku_procurement_unit_id = $request->sku_procurement_unit_id;

            // $data->sku_category = $request->sku_category;
            // $data->sku_sub_category = $request->sku_sub_category;
            $data->flag_active = 1;
            $data->flag_show = 1;

            // handle item production material insert item base on type
            if($request->flag_sku_type == 2){
                $this->handleAddItemProduction($data);
            }else{
                $data->save();
            }
    }

    function handleAddItemProduction($data){
        // get type by id
        $type = MasterSkuType::where('id', $data->sku_type_id)->firstOrFail();
        // $group_tags = $types->map(function ($type) {
        //     return $type->group_tag;
        // })->toArray();

        // get type by group tag
        $group_types = MasterSkuType::where('group_tag', $type->group_tag)->get();


        foreach ($group_types as $group_type) {
            $copyData = $data->replicate();

            // FIXME BUG CODE
            $result_code =  $this->generateCode($data->sku_type_id,$data->flag_sku_type);
            $copyData->manual_id = $result_code['code'];
            $copyData->counter = $result_code['counter'];

            $copyData->sku_type_id = $group_type->id;

            $copyData->save();
        }

    }

    public function delete($id){
        $data = MasterSku::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->save();
    }

    public function get(int $id)
    {
        return MasterSku::where('id', $id)->firstOrFail();
    }

    function edit(Request $request)
    {
        $data = MasterSku::where('id', $request->id)->firstOrFail();

        $data->manual_id = $request->manual_id;
        $data->description = $request->description;
        $data->group_tag = $request->group_tag;
        $data->specification_code = $request->specification_code;
        $data->specification_detail = $request->specification_detail;

        $data->sku_sales_category_id = $request->sku_sales_category_id;
        $data->sku_business_type_id = $request->sku_business_type_id;
        $data->val_weight = $request->val_weight;
        $data->val_area = $request->val_area;
        $data->sku_model_id = $request->sku_model_id;

        $data->sku_inventory_unit_id = $request->sku_inventory_unit_id;
        $data->val_conversion = $request->val_conversion;
        $data->flag_inventory_register = $this->convertCheckboxToBoolean ($request->flag_inventory_register);

        $data->sku_type_id = $request->sku_type_id;
        $data->flag_sku_procurement_type = $request->flag_sku_procurement_type;
        $data->sku_procurement_unit_id = $request->sku_procurement_unit_id;

        // $data->sku_category = $request->sku_category;
        // $data->sku_sub_category = $request->sku_sub_category;

        $data->save();
    }

}

