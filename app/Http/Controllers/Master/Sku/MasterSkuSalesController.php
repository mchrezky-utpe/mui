<?php

namespace App\Http\Controllers\Master\Sku;

use App\Helpers\HelperCustom;
use App\Services\Master\Sku\MasterSkuSalesService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterSkuSalesController
{

    private MasterSkuSalesService $service;

    public function __construct(
        MasterSkuSalesService $service,
    )
    { 
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()
            ->view('master.sku_sales.index',
             [
                'data' =>  $this->service->list()
            ]);
    }

    public function api_droplist()
    {
        $data = $this->service->droplist();
         return response()->json([
            'data' => $data
        ]);
    }

}
