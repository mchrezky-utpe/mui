<?php

namespace App\Services\Master;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\HelperCustom;
use App\Models\MasterSkuProcessType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MasterSkuProcessTypeService
{
    public function list(){
        return MasterSkuProcessType::where('flag_active', 1)->get();
    }

    public function add(Request $request) {
        $data = $request->validate([
            'name'            => 'required|string|max:100',
            'category'        => 'required|string|in:IN-HOUSE,PURCHASE',
            'mst_sku_type_id' => 'required|integer|exists:mst_sku_type,id',
        ]);

        $data['category'] = strtoupper($data['category']);
        $data['flag_active'] = 1;
        $data = MasterSkuProcessType::create($data);
        $data["code"] = HelperCustom::generateTrxNo("PTC-", $data->id);
        $data->save();
        
        // $data['description'] = $request->description;
        // // $data['manual_id'] = $request->manual_id;
        // $data['generated_id'] = Str::uuid()->toString();
        // $data = MasterSkuProcessType::create($data);
        // $data["code"] = HelperCustom::generateTrxNo("PTC-", $data->id);
        // // $data['prefix'] = HelperCustom::generateTrxNo('SKUT', $data->id);
        // $data->save();
    }

    public function delete($id){
        $data = MasterSkuProcessType::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterSkuProcessType::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterSkuProcessType::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id = $request->manual_id;
        $data->save();
    }

    public function pagination_sku_process_type(Request $request){
            $start = $request->input('start') ?: 1;
            $length = $request->input('length') ?: 10; 
            $search = $request->input('search.value');
            // $query = DB::table('mst_sku_process_type');
            $query = MasterSkuProcessType::with("item_type");
            // $query = DB::table('vw_app_list_mst_sku');
            
            $query->where('flag_active', '=', 1);

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%$search%")
                    ->orWhere("category", 'like', "%$search%")
                    ->orWhere("name", 'like', "%$search%");
                });
            }


            // // $query->where('sku_type_flag_checking','=',4); // unchecked type
        
            // if (!empty($search)) {
            //     $query->where(function ($q) use ($search) {
            //         $q->Where('sku_id', 'like', '%' . $search . '%')
            //             ->orWhere('sku_name', 'like', '%' . $search . '%')
            //             ->orWhere('sku_specification_code', 'like', '%' . $search . '%');
            //     });
            // }

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
}