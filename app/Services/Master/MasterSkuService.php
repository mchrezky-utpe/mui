<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterSku;
use App\Models\Master\Sku\SkuListVw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MasterSkuService
{

    function convertCheckboxToBoolean($value)
    {
        return $value === 'on';
    }

    public function list(){
          return SkuListVw::all();
    }

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

    function generateCode($sku_type_id, $flag_sku_type){
        $prefix;
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
      
      $code = $result->sku;;
      $parts = explode("-", $code);
      $counter = (int)$parts[1];
      return  array(
        'code' => $code,
        'counter' => $counter
      );
    }

    public function add(Request $request){
      
            $sku_type_id = 5;
            if($request->flag_sku_type != 1){
                $sku_type_id = $request->sku_type_id;
            }
            $result_code =  $this->generateCode($sku_type_id,$request->flag_sku_type);
         
            $data = new MasterSku();

            $data->manual_id = $result_code['code'];
            $data->counter = $result_code['counter'];
            
            $data->group_tag = $request->$group_tag;
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
            $data->sku_type_id = $request->sku_type_id;
            $data->flag_sku_procurement_type = $request->flag_sku_procurement_type;
            $data->sku_procurement_unit_id = $request->sku_procurement_unit_id;

            // $data->sku_category = $request->sku_category;
            // $data->sku_sub_category = $request->sku_sub_category;
            $data->flag_active = 1;
            $data->flag_show = 1;

            $data = $data->save();
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
        $data->spesification_code = $request->spesification_code;
        $data->spesification_description = $request->spesification_description;
      
        $data->sku_sales_category_id = $request->sku_sales_category_id;
        $data->sku_business_type_id = $request->sku_business_type_id;
        $data->val_weight = $request->val_weight;
        $data->val_area = $request->val_area;
        $data->sku_model_id = $request->sku_model_id;

        $data->sku_inventory_unit_id = $request->sku_inventory_unit_id; 
        $data->val_conversion = $request->val_conversion; 
        $data->flag_inventory_register = $request->flag_inventory_register; 

        $data->sku_type_id = $request->sku_type_id;
        $data->flag_sku_procurement_type = $request->flag_sku_procurement_type;
        $data->sku_procurement_unit_id = $request->sku_procurement_unit_id;

        $data->sku_category = $request->sku_category;
        $data->sku_sub_category = $request->sku_sub_category;

        $data->save();
    }

}