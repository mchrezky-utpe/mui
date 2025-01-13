<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(Request $request): bool
    {
        $username = $request->input("username");
        $password = $request->input("password");
        $result = User::firstWhere(['username' => $username]);
        if ($result != null && md5($password) == $result->password) {
            $request->session()->put("user", $result);
            return true;
        } else {
            return false;
        }
    }
}
