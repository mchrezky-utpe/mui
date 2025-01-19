<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Master\MasterGeneralOtherCostService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterGeneralOtherCostController
{

    private MasterGeneralOtherCostService $service;

    public function __construct(MasterGeneralOtherCostService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('master.general_other_cost.index',
         ['data' =>  $this->service->list()]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/general-other-cost");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/general-other-cost");
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
        return redirect("/general-other-cost");
    }
}
