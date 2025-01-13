<?php

namespace App\Http\Controllers;

use App\Helpers\HelperCustom;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()
            ->view('user.index', ['data' =>  $this->service->list()
            ]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/user");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/user");
    }

    
    public function get(Request $request, int $id)
    {
        $user = $this->service->get($id);
        return response()->json([
            'data' => $user
        ]);
    }

    public function edit(Request $request)
    {
        $this->service->edit($request);
        return redirect("/user");
    }
}
