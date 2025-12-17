<?php

namespace App\Http\Controllers\Master;

// use App\Helpers\HelperCustom;
use App\Services\Master\MasterSkuBusinessService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterSkuBusinessController
{
    private MasterSkuBusinessService $service;
    private $route = "/sku-business-type";

    public function __construct(MasterSkuBusinessService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()
            ->view('master.sku_business_type.index', ['data' =>  $this->service->list()
            ]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect($this->route);
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect($this->route);
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
        return redirect($this->route);
    }

    public function api_droplist()
    {
        $data = $this->service->droplist();
         return response()->json([
            'data' => $data
        ]);
    }
}
