<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterGeneralTerms;
use App\Models\MasterGeneralTermsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class MasterGeneralTermsService
{
    public function list(){
        //   return MasterGeneralTerms::all();
          return MasterGeneralTerms::where('flag_active', 1)->orderBy('created_at','DESC')->get();
    }
    public function list2(){
        //   return MasterGeneralTerms::all();
          return MasterGeneralTerms::where('flag_active', 0)->get();
    }

    public function add(Request $request){
        
            $result_code =  $this->generateCode();
            $data['manual_id'] = $result_code['code'];
            $data['counter'] = $result_code['counter'];

            $data['description'] = $request->description;
            $data['generated_id'] = Str::uuid()->toString();
            $data['flag_active'] = 1;
            $data = MasterGeneralTerms::create($data);
            $data['prefix'] = HelperCustom::generateTrxNo('GEN-T-', $data->id);
            $data->save();
            $items;
    
            // Detail Data
            if($request->description_detail){
                foreach ($request->detail_id as $index => $detail_id) {
                    $items[] = [
                        'description' => $request->description_detail[$index],
                        'flag_active' => 1,
                        'flag_show' => 1,
                        'generated_id' => Str::uuid()->toString(),
                        'general_terms_id' => $data->id, 
                    ];
                }
                MasterGeneralTermsDetail::insert($items);
        }
    }

    
    

    public function generateCode(){

      $result = DB::selectOne(" SELECT generate_term_code(?) AS code ",["TC"]);

      $code = $result->code;
      $parts = explode("-", $code);
      $counter = (int)$parts[1];
      return  array(
        'code' => $code,
        'counter' => $counter
      );
    }

    public function delete($id){
        $data = MasterGeneralTerms::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    public function restore($id){
        $data = MasterGeneralTerms::where('id', $id)->firstOrFail();
        $data->flag_active = 1;
        $data->deleted_at  = Carbon::now();
        $data->deleted_by  = Auth::id();
        $data->save();
    }
    public function hapus($id){
        $data = MasterGeneralTerms::where('id', $id)->firstOrFail();
        $data->delete();
    }
    
    public function get(int $id)
    {
        return MasterGeneralTerms::with(['details'])->where('id', $id)->firstOrFail();
    } 

    public function get_by(Request $request){
        $query = MasterGeneralTerms::with(['details'])
        ->where('flag_active', 1);
        foreach ($request->all() as $field => $value) {
            if (!empty($value)) {
                $query->where($field, $value);
            }
        }
       return $query->get();
    }

    function edit(Request $request)
    {
        $data = MasterGeneralTerms::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->manual_id= $request->manual_id;
        $data->save();
        
    // Handle updating or inserting details
    if ($request->has('description_detail')) {
        // Loop through the details arrays
        foreach ($request->detail_id as $index => $detailId) {
            $description = $request->description_detail[$index];

            if ($detailId) {
                // Update existing record if ID is present
                $existingDetail = MasterGeneralTermsDetail::find($detailId);
                if ($existingDetail) {
                    $existingDetail->description = $description;
                    $existingDetail->flag_active = true; // Keep the existing detail active
                    $existingDetail->save();
                }
            } else {
                // If no ID exists, insert a new record
                MasterGeneralTermsDetail::create([
                    'general_terms_id' =>  $data->id,
                    'description' => $description,
                    'flag_active' => true, // New details are active by default
                ]);
            }
        }
    }
    // Deactivate any existing details not included in the request
    MasterGeneralTermsDetail::where('general_terms_id', $data->id)
        ->whereNotIn('id', $request->detail_id)
        ->where('flag_active', true)
        ->update(['flag_active' => false]);
    }
}