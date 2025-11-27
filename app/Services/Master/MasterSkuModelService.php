<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterSkuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Master\Sku\SkuModelListVw;
use Illuminate\Support\Facades\DB;

class MasterSkuModelService
{
    public function list(){
          return MasterSkuModel::where('flag_active', 1)->orderBy('created_at','desc')->get();
    }

    public function add(Request $request){
        
            $data['prefix'] = $request->prefix;
            $result_code =  $this->generateCode();
            $data['manual_id'] = $result_code['code'];
            $data['counter'] = $result_code['counter'];
            
            $data['description'] = $request->description;
            $data['generated_id'] = Str::uuid()->toString();
            $data['image_path'] = 'tes'; // TODO IMPLEMENT UPLOAD
            $data['flag_active'] = 1;
            $data = MasterSkuModel::create($data);
            // $data['prefix'] = HelperCustom::generateTrxNo('SKUM', $data->id);
            $data->save();
    }
    

    public function generateCode(){

      $result = DB::selectOne(" SELECT generate_item_model_code(?) AS code ",["IMC"]);

      $code = $result->code;
      $parts = explode("-", $code);
      $counter = (int)$parts[1];
      return  array(
        'code' => $code,
        'counter' => $counter
      );
    }

    public function delete($id){
        $data = MasterSkuModel::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterSkuModel::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterSkuModel::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->image_path = $request->image_path; // TODO UPLOAD
        $data->save();
    }
    
    public function droplist(){
        return SkuModelListVw::all();
    }
}