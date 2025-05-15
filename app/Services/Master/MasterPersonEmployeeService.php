<?php

namespace App\Services\Master;

use App\Helpers\HelperCustom;
use App\Models\MasterPersonEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MasterPersonEmployeeService
{

    public function list(){
        return MasterPersonEmployee::where('flag_active', 1)->get();
    }
    public function list2(){
        return MasterPersonEmployee::where('flag_active', 0)->get();
    }

    public function add(Request $request){
        $data['firstname'] = $request->firstname;
        $data['middlename'] = $request->middlename;
        $data['lastname'] = $request->lastname;
        $data['fullname'] = $request->fullname;
        $data['flag_gender'] = $request->flag_gender;
        $data['flag_active'] = 1;
        $data = MasterPersonEmployee::create($data);
        // $data['prefix'] = HelperCustom::generateTrxNo('SUP', $data->id);
        $data->save();
    }

    public function delete($id){
        $data = MasterPersonEmployee::where('id', $id)->firstOrFail();
        $data->flag_active = 0;
        $data->save();
    }
    // public function Restore($id){
    //     $data = MasterPersonEmployeeService::where('id', $id)->firstOrFail();
    //     $data->flag_active = 1;
    //     $data->save();
    // }
    // public function hapus($id){
    //     $data = MasterPersonEmployeeService::where('id', $id)->firstOrFail();
    //     $data->delete();
    // }

    public function get(int $id)
    {
        return MasterPersonEmployee::where('id', $id)->firstOrFail();
    } 

    function edit(Request $request)
    {
        $data = MasterPersonEmployee::where('id', $request->id)->firstOrFail();
        $data->firstname = $request->firstname;
        $data->middlename = $request->middlename;
        $data->lastname = $request->lastname;
        $data->fullname = $request->fullname;
        $data->flag_gender = $request->flag_gender;
        $data->save();
    }
}