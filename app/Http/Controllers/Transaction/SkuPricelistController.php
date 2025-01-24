<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\HelperCustom;
use App\Services\Transaction\SkuPricelistService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SkuPricelistController
{

    private SkuPricelistService $service;

    public function __construct(SkuPricelistService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('transaction.sku_pricelist.index',
         ['data' =>  $this->service->list()]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku-pricelist");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-pricelist");
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
        return redirect("/sku-pricelist");
    }
}
