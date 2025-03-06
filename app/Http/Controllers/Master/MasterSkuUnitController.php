<?php

namespace App\Http\Controllers\Master;

use App\Services\Master\MasterSkuUnitService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterSkuUnitController
{

    private MasterSkuUnitService $service;

    public function __construct(MasterSkuUnitService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('master.sku_unit.index', ['data' =>  $this->service->list()]);
    }

    public function api_all()
    {
        $data = $this->service->list();
         return response()->json([
            'data' => $data
        ]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku-unit");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-unit");
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
        return redirect("/sku-unit");
    }

    public function api_droplist()
    {
        $data = $this->service->droplist();
         return response()->json([
            'data' => $data
        ]);
    }
}
