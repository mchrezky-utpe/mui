<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Master\MasterPersonCustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterPersonCustomerController
{

    private MasterPersonCustomerService $service;

    public function __construct(MasterPersonCustomerService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('master.person_customer.index',
         ['data' =>  $this->service->list()]);
    }
    public function index2(): Response
    {
        return response()->view('master.person_customer.index2',
         ['data' =>  $this->service->list2()]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/person-customer");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/person-customer");
    }
    public function restore(Request $request, int $id)
    {
        $this->service->restore($id);
        return redirect("/person-customer/index2");
    }
    public function hapus(Request $request, int $id)
    {
        $this->service->hapus($id);
        return redirect("/person-customer/index2");
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
        return redirect("/person-customer");
    }
}
