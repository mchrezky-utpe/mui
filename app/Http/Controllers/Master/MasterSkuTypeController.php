<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Master\MasterSkuTypeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterSkuTypeController
{ 

    private MasterSkuTypeService $service;

    public function __construct(MasterSkuTypeService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()
            ->view('master.sku_type.index', ['data' =>  $this->service->list()
            ]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku-type");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-type");
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
        return redirect("/sku-type");
    }

    public function api_droplist()
    {
        $data = $this->service->droplist();
         return response()->json([
            'data' => $data
        ]);
    }
}
