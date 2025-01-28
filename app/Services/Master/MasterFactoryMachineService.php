<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterFactoryMachine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MasterFactoryMachineService
{
    public function list(){
        //   return MasterFactoryMachine::all();
          return MasterFactoryMachine::where('flag_active', 1)->get();
    }
    public function list2(){
        //   return MasterFactoryMachine::all();
          return MasterFactoryMachine::where('flag_active', 0)->get();
    }

    public function add(Request $request){
        // dd($request);
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = MasterFactoryMachine::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('F-M-', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = MasterFactoryMachine::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterFactoryMachine::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterFactoryMachine::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
    public function restore($id){
        $data = MasterFactoryMachine::where('id', $id)->firstOrFail();
        $data->flag_active = 1;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    public function hapus($id){
        $data = MasterFactoryMachine::where('id', $id)->firstOrFail();
        $data->delete();
    }
    
}