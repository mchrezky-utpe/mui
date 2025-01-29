<?php

namespace App\Services\Transaction\Inventory;

use App\Helpers\HelperCustom;
use App\Models\Transaction\Inventory\InventoryAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class InventoryAdjustmentService
{
    public function list(){
        //   return InventoryAdjustment::all();
          return InventoryAdjustment::where('flag_active', 1)->get();
    }

    public function add(Request $request){
        // dd($request);
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = InventoryAdjustment::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('I-Adj-', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = InventoryAdjustment::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return InventoryAdjustment::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = InventoryAdjustment::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
    
}