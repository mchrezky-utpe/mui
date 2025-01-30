<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterFactoryWarehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MasterFactoryWarehouseService
{
    public function list(){
        //   return MasterFactoryWarehouse::all();
          return MasterFactoryWarehouse::where('flag_active', 1)->get();
    }
    public function list2(){
        //   return MasterFactoryWarehouse::all();
          return MasterFactoryWarehouse::where('flag_active', 0)->get();
    }

    public function add(Request $request){
        // dd($request);
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = MasterFactoryWarehouse::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('F-W-', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = MasterFactoryWarehouse::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterFactoryWarehouse::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterFactoryWarehouse::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
    public function restore($id){
        $data = MasterFactoryWarehouse::where('id', $id)->firstOrFail();
        $data->flag_active = 1;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    public function hapus($id){
        $data = MasterFactoryWarehouse::where('id', $id)->firstOrFail();
        $data->delete();
    }
    
}