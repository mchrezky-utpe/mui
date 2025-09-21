<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterPersonSupplier;
use App\Models\VwExportMasterPersonSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MasterPersonSupplierService
{

    public function list(){
        return VwExportMasterPersonSupplier::where('flag_active', 1)->orderBy('created_at', 'DESC')->take(1000)->get();
    }
    public function list2(){
        return VwExportMasterPersonSupplier::where('flag_active', 0)->orderBy('created_at', 'DESC')->take(1000)->get();
    }

    public function add(Request $request){
        $data['description'] = $request->description;
        $data['prefix'] = $request->prefix;
        $data['contact_person_01'] = $request->contact_person_01;
        $data['phone_02'] = $request->phone_02;
        $data['contact_person_02'] = $request->contact_person_02;
        $data['email_02'] = $request->email_02;
        $data['contact_person_03'] = $request->contact_person_03;
        $data['email_03'] = $request->email_03;
        $data['address_01'] = $request->address_01;
        $data['phone_01'] = $request->phone;
        $data['fax_01'] = $request->fax;
        $data['email_01'] = $request->email;
        $data['contact_person_01'] = $request->contact_person;
        $data['flag_active'] = 1;
        $data['flag_show'] = 1;
        $data['generated_id'] = Str::uuid()->toString();
        $data = MasterPersonSupplier::create($data);
        $data['manual_id'] = HelperCustom::generateTrxNo('SUP', $data->id);
        $data->save();
    }

    public function delete($id){
        $data = MasterPersonSupplier::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->save();
    }
    public function Restore($id){
        $data = MasterPersonSupplier::where('id', $id)->firstOrFail();
        $data->flag_active = 1;
        $data->save();
    }
    public function hapus($id){
        $data = MasterPersonSupplier::where('id', $id)->firstOrFail();
        $data->delete();
    }

    public function get(int $id)
    {
        return MasterPersonSupplier::where('id', $id)->firstOrFail();
    }
    
    // public function get($id)
    // {
    //     if (is_numeric($id)) {
    //         return MasterPersonSupplier::where('id', $id)->firstOrFail();
    //     } else {
    //         return MasterPersonSupplier::where('manual_id', $id)->firstOrFail();
    //     }
    // }

    function edit(Request $request)
    {
        $data = MasterPersonSupplier::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->prefix = $request->prefix;
        $data->address_01 = $request->address_01;
        $data->contact_person_01 = $request->contact_person_01;
        $data->phone_02 = $request->phone_02;
        $data->contact_person_02 = $request->contact_person_02;
        $data->email_02 = $request->email_02;
        $data->contact_person_03 = $request->contact_person_03;
        $data->email_03 = $request->email_03;
        $data->address_01 = $request->address_01;
        $data->phone_01 = $request->phone;
        $data->fax_01 = $request->fax;
        $data->email_01 = $request->email;
        $data->contact_person_01 = $request->contact_person;
        $data->save();
    }
}