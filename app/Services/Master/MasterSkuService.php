<?php

namespace App\Services\Master;

use App\Models\MasterSku;
use App\Models\Master\Sku\MasterSkuType;
use App\Models\Master\Sku\SkuListVw;
use App\Models\Master\Sku\SkuListSetCodeVw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterSkuService 
{

    function convertCheckboxToBoolean($value)
    {
        return $value === 'on';
    }

    public function list_part_information__raw() {
        return SkuListVw::where('flag_sku_type', 1)->orderBy('created_at', 'DESC');
    }

    public function list_part_information($limit = 1000){
        return $this->list_part_information__raw()->take($limit)->get();
        // return SkuListVw::where('flag_sku_type', 1)->orderBy('created_at', 'DESC');
    }

    public function list_production_material_information__raw(){
        return SkuListVw::where('flag_sku_type', 2)->orderBy('created_at', 'DESC');
    }

    public function list_production_material_information(){
        return $this->list_production_material_information__raw()->take(100000)->get();
    }

    public function list_general_information__raw(){
        return SkuListVw::where('flag_sku_type', 3)->orderBy('created_at', 'DESC');
    }

    public function list_general_information(){
        return $this->list_general_information__raw()->take(1000)->get();
    }

    public function list_pagination_part_information(Request $request) {
            $start = $request->input('start') ?: 1;
            $length = $request->input('length') ?: 10; 
            $search = $request->input('search.value');
            $query = DB::table('vw_app_list_mst_sku');
            
            $query->where('flag_sku_type','=',1);
            // $query->where('sku_type_flag_checking','=',4); // unchecked type
        
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->Where('sku_id', 'like', '%' . $search . '%')
                        ->orWhere('sku_name', 'like', '%' . $search . '%')
                        ->orWhere('sku_specification_code', 'like', '%' . $search . '%');
                });
            }

            $recordsTotal = $query->count();
            $recordsFiltered = $query->count();
            
            if ($length > 0){        
                $data = $query->limit($length)->offset($start)->get();
            }
            else{
                $data = $query->get();
            }

            return [
                'data' => $data,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered
            ];
    }
     
    public function list_pagination_production_material_information(Request $request){
            $start = $request->input('start') ?: 1;
            $length = $request->input('length') ?: 10; 
            $search = $request->input('search.value');
            $query = DB::table('vw_app_list_mst_sku');
            
            $query->where('flag_sku_type','=',2);
            $query->where('sku_type_flag_checking','=',4); // unchecked type
        
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->Where('sku_id', 'like', '%' . $search . '%')
                        ->orWhere('sku_name', 'like', '%' . $search . '%')
                        ->orWhere('sku_specification_code', 'like', '%' . $search . '%');
                });
            }

            $recordsTotal = $query->count();
            $recordsFiltered = $query->count();
            
            if ($length > 0){        
                $data = $query->limit($length)->offset($start)->get();
            }
            else{
                $data = $query->get();
            }

            return [
                'data' => $data,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered
            ];
     
        }
     
    public function list_pagination_general_information(Request $request){
            $start = $request->input('start');
            $length = $request->input('length'); 
            $search = $request->input('search.value');
            $query = DB::table('vw_app_list_mst_sku');
             
            $query->where('flag_sku_type','=',3);
        
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->Where('sku_id', 'like', '%' . $search . '%')
                        ->orWhere('sku_name', 'like', '%' . $search . '%')
                        ->orWhere('sku_specification_code', 'like', '%' . $search . '%');
                });
            }

            $recordsTotal = $query->count();
            $recordsFiltered = $query->count();
            
            if ($length > 0){        
                $data = $query->limit($length)->offset($start)->get();
            }
            else{
                $data = $query->get();
            }

            return [
                'data' => $data,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered
            ];
     
        }

    public function get_all_sku(){
          return SkuListVw::orderBy('created_at', 'DESC')->take(1000)->get();
    }

    // public function get_all_name_n_ext() {
    //     return DB::table("mst_sku")->orderBy('created_at', 'DESC')->get();
    // }
     
    public function get_set_code(){

      $existingData = SkuListSetCodeVw::all();
    
        try {
            $lastCode = SkuListSetCodeVw::orderBy('code', 'desc')->value('code');
            
            if (!$this->isValidCodeFormat($lastCode)) {
                return $existingData;
            }
            
            $lastNumber = intval(substr($lastCode, -5));
            $prefix = substr($lastCode, 0, -5);
            
            $newCode = $prefix . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            
            if ($this->isValidCodeFormat($newCode)) {
                $existingData->push(['code' => $newCode]);
            }
            
        } catch (\Exception $e) {
            dd('Error generating SKU code: ' . $e->getMessage());
        }
        
        return $existingData;

    }

    private function isValidCodeFormat($code)
    {
        if (empty($code) || !is_string($code)) {
            return false;
        }
        
        // Validasi format: SCO-XXXXX (3 huruf, dash, 5 angka)
        return preg_match('/^[A-Z]{3}-\d{5}$/', $code) === 1;
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

        try{
            $sku_type_id = $request->sku_type_id;
            $result_code =  $this->generateCode($sku_type_id,$request->flag_sku_type);
            $data = new MasterSku();

            $data->manual_id = $result_code['code'];
            $data->counter = $result_code['counter'];

            $data->group_tag = $request->group_tag;
            $data->set_code = $request->group_tag;
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

        
            if ($request->hasFile('blob_image')) {
                $image = $request->file('blob_image');
                $imageData = file_get_contents($image->getRealPath());
                 $data->blob_image = base64_encode($imageData);
            }

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
             }catch (\Exception $e) {
            dd($e);
        }
    }

    function handleAddItemProduction($data){
        // get type by id
        $type = MasterSkuType::where('id', $data->sku_type_id)->firstOrFail();

        // get type by group tag
        $group_types = MasterSkuType::where('group_tag', $type->group_tag)->get();
        
        $result_code =  $this->generateCode($group_types->first()->id, $data->flag_sku_type);

        foreach ($group_types as $group_type) {
            $copyData = $data->replicate();
            
            $validCode = 
            $this->generateCustomString(
                $group_types->first()->prefix, 
                $group_type->prefix, 
                $result_code['code'] );

            $copyData->manual_id = $validCode;
            $copyData->counter = $result_code['counter'];

            $copyData->sku_type_id = $group_type->id;

            $copyData->save();
        }

    }

    function generateCustomString($prefix_old, $prefix_new, $baseString)
    {
        return str_replace($prefix_old, $prefix_new, $baseString);
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

        
            if ($request->hasFile('blob_image')) {
                $image = $request->file('blob_image');
                $imageData = file_get_contents($image->getRealPath());
                 $data->blob_image = base64_encode($imageData);
            }

        // $data->sku_category = $request->sku_category;
        // $data->sku_sub_category = $request->sku_sub_category;

        $data->save();
    }

}

