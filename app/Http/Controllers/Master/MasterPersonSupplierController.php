<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Master\MasterPersonSupplierService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterPersonSupplierController
{

    private MasterPersonSupplierService $service;

    public function __construct(MasterPersonSupplierService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('master.person_supplier.index',
         ['data' =>  $this->service->list()]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/person-supplier");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/person-supplier");
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
        return redirect("/person-supplier");
    }
}
