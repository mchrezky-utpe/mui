<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterSkuBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Master\Sku\SkuBusinessListVw;

class MasterSkuBusinessService
{

    private $allowedCategory = ['AUTOMOTIVE', 'NON-AUTOMOTIVE'];
    
    public function list(){
        return MasterSkuBusiness::where('flag_active', 1)->get();
    }

    public function add(Request $request){

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', $this->allowedCategory),
            
            // 'category' => 'required|in:AUTOMOTIVE,NON-AUTOMOTIVE',
            // 'code' => 'required|string|max:255',
        ]);
        
        
        // $data["name"] = $request->name;
        // $data["code"] = $request->code;
        // $data["category"] = $request->category;

        $data['flag_active'] = 1;
        $data = MasterSkuBusiness::create($data);
        $data['code'] = HelperCustom::generateTrxNo('SKUT', $data->id);
        $data->save();
    }
    // public function add(Request $request){
    //     $data['description'] = $request->description;
    //     $data['manual_id'] = $request->manual_id;
    //     $data['generated_id'] = Str::uuid()->toString();
    //     $data['flag_active'] = 1;
    //     $data = MasterSkuBusiness::create($data);
    //     $data['prefix'] = HelperCustom::generateTrxNo('SKUT', $data->id);
    //     $data->save();
    // }

    public function delete($id){
        $data = MasterSkuBusiness::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterSkuBusiness::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterSkuBusiness::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }

    public function droplist(){
        return SkuBusinessListVw::all();
    }

    public function pagination(Request $request)
    {
        $start  = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $search = $request->input('search.value');

        $query = MasterSkuBusiness::query()
            ->where('flag_active', 1);

        $recordsTotal = MasterSkuBusiness::where('flag_active', 1)->count();

        // search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // total setelah filter
        $recordsFiltered = $query->count();

        // data
        $data = $query
            ->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        return [
            'data'            => $data,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
        ];
    }

}