<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterSkuUnit;
use App\Models\Master\Sku\SkuUnitListVw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MasterSkuUnitService
{

    public function list(){
          return SkuUnitListVw::orderBy('manual_id')->orderBy('created_at','desc')->get();
    }

    public function add(Request $request){
        
            $result_code =  $this->generateCode();
            $data['prefix'] = $result_code['code'];
            $data['counter'] = $result_code['counter'];

            $data['description'] = $request->description;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = MasterSkuUnit::create($data);
            $data->save();
    }

    public function delete($id){
        $data = MasterSkuUnit::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterSkuUnit::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterSkuUnit::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->save();
    }

    public function droplist(){
        return SkuUnitListVw::all();
    }
    
    public function generateCode(){

        $result = DB::selectOne(" SELECT generate_unit_code(?) AS code ",["IUC"]);

        $code = $result->code;
        $parts = explode("-", $code);
        $counter = (int)$parts[1];
        return  array(
            'code' => $code,
            'counter' => $counter
        );
        }
}