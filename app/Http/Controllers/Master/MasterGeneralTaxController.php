<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Master\MasterGeneralTaxService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterGeneralTaxController
{

    private MasterGeneralTaxService $service;

    public function __construct(MasterGeneralTaxService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('master.general_tax.index',
         ['data' =>  $this->service->list()]);
    }
    public function index2(): Response
    {
        return response()->view('master.general_tax.index2',
         ['data' =>  $this->service->list2()]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/general-tax");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/general-tax");
    }
    public function restore(Request $request, int $id)
    {
        $this->service->restore($id);
        return redirect("/general-tax/index2");
    }
    public function hapus(Request $request, int $id)
    {
        $this->service->hapus($id);
        return redirect("/general-tax/index2");
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
        return redirect("/general-tax");
    }
}
