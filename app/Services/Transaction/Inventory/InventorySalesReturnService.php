<?php

namespace App\Services\Transaction\Inventory;

use App\Helpers\HelperCustom;
use App\Models\Transaction\Inventory\InventorySalesReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class InventorySalesReturnService
{
    public function list(){
        //   return InventoryDo::all();
          return InventorySalesReturn::where('flag_active', 1)->get();
    }

    public function add(Request $request){
        // dd($request);
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = InventorySalesReturn::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('I-S-R-', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = InventorySalesReturn::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return InventorySalesReturn::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = InventorySalesReturn::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
    
}