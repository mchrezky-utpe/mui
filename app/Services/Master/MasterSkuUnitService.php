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
          return SkuUnitListVw::orderBy('created_at','DESC')->get();
    }

    public function add(Request $request){
        
            $data['description'] = $request->description;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = MasterSkuUnit::create($data);
            $data['manual_id'] = HelperCustom::generateTrxNo('UC-', $data->id);
            $data['prefix'] = $request->prefix;
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

    function edit(Request $request,int $id)
    {
        $data = MasterSkuUnit::where('id', $id)->firstOrFail();
        $data->description = $request->description;
        // $data->manual_id= $request->manual_id;
        $data->save();
    }

    public function droplist(){
        return SkuUnitListVw::all();
    }
    
    public function generateCode(){

        $result = DB::selectOne(" SELECT generate_unit_code(?) AS code ",["UC"]);

        $code = $result->code;
        $parts = explode("-", $code);
        $counter = (int)$parts[1];
        return  array(
            'code' => $code,
            'counter' => $counter
        );
        }
}