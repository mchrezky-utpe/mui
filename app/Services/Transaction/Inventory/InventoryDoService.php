<?php

namespace App\Services\Transaction\Inventory;

use App\Helpers\HelperCustom;
use App\Models\Transaction\Inventory\InventoryDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class InventoryDoService
{
    public function list(){
        //   return InventoryDo::all();
          return InventoryDo::where('flag_active', 1)->get();
    }

    public function add(Request $request){
        // dd($request);
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = InventoryDo::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('I-D-O-', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = InventoryDo::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return InventoryDo::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = InventoryDo::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
    
}