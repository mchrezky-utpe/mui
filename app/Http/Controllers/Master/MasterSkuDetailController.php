<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Master\MasterSkuDetailService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterSkuDetailController
{

    private MasterSkuDetailService $service;

    public function __construct(MasterSkuDetailService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()
            ->view('master.sku_detail.index', ['data' =>  $this->service->list()
            ]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku-detail");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-detail");
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
        return redirect("/sku-detail");
    }
}
