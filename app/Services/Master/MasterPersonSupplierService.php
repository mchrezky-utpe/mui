<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterPersonSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MasterPersonSupplierService
{

    public function list(){
        return MasterPersonSupplier::where('flag_active', 1)->get();
    }
    public function list2(){
        return MasterPersonSupplier::where('flag_active', 0)->get();
    }

    public function add(Request $request){
        $data['description'] = $request->description;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['fax'] = $request->fax;
        $data['email'] = $request->email;
        $data['contact_person'] = $request->contact_person;
        $data['flag_active'] = 1;
        $data['flag_show'] = 1;
        $data['manual_id'] = $request->manual_id;
        $data['generated_id'] = Str::uuid()->toString();
        $data = MasterPersonSupplier::create($data);
        $data['prefix'] = HelperCustom::generateTrxNo('SUP', $data->id);
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

    function edit(Request $request)
    {
        $data = MasterPersonSupplier::where('id', $request->id)->firstOrFail();
        $data->description = $request->description;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->fax = $request->fax;
        $data->email = $request->email;
        $data->contact_person = $request->contact_person;
        $data->manual_id= $request->manual_id;
        $data->save();
    }
}