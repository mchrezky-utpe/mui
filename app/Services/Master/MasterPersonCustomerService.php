<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterPersonCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MasterPersonCustomerService
{

    public function list(){
        return MasterPersonCustomer::where('flag_active', 1)->get();
    }
    public function list2(){
        return MasterPersonCustomer::where('flag_active', 0)->get();
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
        $data = MasterPersonCustomer::create($data);
        $data['prefix'] = HelperCustom::generateTrxNo('CUS', $data->id);
        $data->save();
    }

    public function delete($id){
        $data = MasterPersonCustomer::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->save();
    }
    public function Restore($id){
        $data = MasterPersonCustomer::where('id', $id)->firstOrFail();
        $data->flag_active = 1;
        $data->save();
    }
    public function hapus($id){
        $data = MasterPersonCustomer::where('id', $id)->firstOrFail();
        $data->delete();
    }

    public function get(int $id)
    {
        return MasterPersonCustomer::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterPersonCustomer::where('id', $request->id)->firstOrFail();
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