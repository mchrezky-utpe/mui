<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterGeneralTerms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MasterGeneralTermsService
{
    public function list(){
        //   return MasterGeneralTerms::all();
          return MasterGeneralTerms::where('flag_active', 1)->get();
    }

    public function add(Request $request){
            $data['description'] = $request->description;
            $data['manual_id'] = $request->manual_id;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = MasterGeneralTerms::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('GEN-T-', $data->id);
            $data->save();
    }

    public function delete($id){
        $data = MasterGeneralTerms::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    
    public function get(int $id)
    {
        return MasterGeneralTerms::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterGeneralTerms::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}