<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Master\MasterGeneralDepartmentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterGeneralDepartmentController
{

    private MasterGeneralDepartmentService $service;

    public function __construct(MasterGeneralDepartmentService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('master.general_department.index',
         ['data' =>  $this->service->list()]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/general-department");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/general-department");
    }
    
    public function get(Request $request, int $id)
    {
        $data = $this->service->get($id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function edit(Request $request)
    {
        $this->service->edit($request);
        return redirect("/general-department");
    }
}
