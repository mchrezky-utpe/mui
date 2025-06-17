<?php

namespace App\Http\Controllers\Master; 

use App\Helpers\HelperCustom;
use App\Services\Master\MasterSkuModelService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterSkuModelController
{

    private MasterSkuModelService $service;

    public function __construct(MasterSkuModelService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()
            ->view('master.sku_model.index', ['data' =>  $this->service->list()
            ]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku-model");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-model");
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
        return redirect("/sku-model");
    }

    public function api_droplist()
    {
        $data = $this->service->droplist();
         return response()->json([
            'data' => $data
        ]);
    }
}
