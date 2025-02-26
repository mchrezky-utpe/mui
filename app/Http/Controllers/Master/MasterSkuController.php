<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Master\MasterSkuService;
use App\Services\Master\MasterSkuTypeService;
use App\Services\Master\MasterSkuDetailService;
use App\Services\Master\MasterSkuModelService;
use App\Services\Master\MasterSkuUnitService;
use App\Services\Master\MasterSkuProcessService;
use App\Services\Master\MasterSkuPackagingService;
use App\Services\Master\MasterSkuBusinessService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterSkuController
{

    private MasterSkuService $service;
    private MasterSkuTypeService $typeService;
    private MasterSkuBusinessService $businessService;

    public function __construct(
        MasterSkuService $service,
        MasterSkuDetailService $detailService,
        MasterSkuUnitService $unitService,
        MasterSkuModelService $modelService,
        MasterSkuTypeService $typeService,
        MasterSkuProcessService $processService,
        MasterSkuBusinessService $businessService,
        MasterSkuPackagingService $packagingService
    )
    { 
        $this->service = $service;
        $this->detailService = $detailService;
        $this->modelService = $modelService;
        $this->unitService = $unitService;
        $this->typeService = $typeService;
        $this->processService = $processService;
        $this->packagingService = $packagingService;
        $this->businessService = $businessService;
    }

    public function index(): Response
    {
        return response()
            ->view('master.sku.index',
             [
                'data' =>  $this->service->list(),
                'type' => $this->typeService->list(),
                'detail' => $this->detailService->list(),
                'unit' => $this->unitService->list(),
                'model' => $this->modelService->list(),
                'packaging' => $this->packagingService->list(),
                'process' => $this->processService->list(),
                'business' => $this->businessService->list()
            ]);
    }

    public function api_all()
    {
        $data = $this->service->list();
         return response()->json([
            'data' => $data
        ]);
    }

    public function get_code(Request $request)
    {
        $data = $this->service->generateCode($request->sku_type_id, $request->flag_sku_type);
         return response()->json([
            'data' => $data
        ]);
    }

    public function get_set_code()
    {
        $data = $this->service->get_set_code();
         return response()->json([
            'data' => $data
        ]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku");
    }

    
    public function get(Request $request, int $id)
    {
        $sku = $this->service->get($id);
        return response()->json([
            'data' => $sku
        ]);
    }

    public function edit(Request $request)
    {
        $this->service->edit($request);
        return redirect("/sku");
    }
}
