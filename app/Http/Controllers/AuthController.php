<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(): Response
    {
        return response()
            ->view("auth.login", [
                "title" => "Login"
            ]);
    }

    public function doLogin(Request $request)
    {
        $username = $request->input("username");
        $password = $request->input("password");

        if (empty($username) || empty($password)) {
            return response()->view("auth.login", [
                "title" => "Login",
                "error" => "user or password is required"
            ]);
        }


        if ($this->service->login($request)) {
            return redirect("/");
        }

        return response()->view("auth.login", [
            "title" => "Login",
            "error" => "Failed Login User or Password /Nonactive"
        ]);
    }

    public function doLogout(Request $request)
    {
        $request->session()->forget("user");
        return redirect("/login");
    }
}
