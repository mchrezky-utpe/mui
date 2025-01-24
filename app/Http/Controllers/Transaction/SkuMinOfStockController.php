<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\HelperCustom;
use App\Services\Transaction\SkuMinOfStockService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SkuMinOfStockController
{

    private SkuMinOfStockService $service;

    public function __construct(SkuMinOfStockService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('transaction.sku_minofstock.index',
         ['data' =>  $this->service->list()]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku-minofstock");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-minofstock");
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
        return redirect("/sku-minofstock");
    }
}
