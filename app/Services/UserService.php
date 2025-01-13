<?php

namespace App\Services;

use App\Helpers\HelperCustom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function list(){
          return User::all();
    }

    public function add(Request $request){
            $user['name'] = $request->name;
            $user['username'] = $request->username;
            $user['password'] = md5($request->password);
            $user['flag_active'] = 1;
            $user = User::create($user);
            $user['prefix'] = HelperCustom::generateTrxNo('US', $user->id);
            $user->save();
    }

    public function delete($id){
        $user = User::where('id', $id)->firstOrFail();
        $user->delete();
    }
    
    public function get(int $id)
    {
        return User::where('id', $id)->firstOrFail();
    }

    function edit(Request $request)
    {
        // get by id
        $user = User::where('id', $request->id)->firstOrFail();
        $user->name = $request->name;
        $user->username = $request->username;
        if ($request->password != null && $request->password != "") {
            $user->password =  md5($request->password);
        }

        $user->save();
    }

}