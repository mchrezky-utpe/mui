<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Transaction\PurchaseOrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PurchaseOrderController
{

    private PurchaseOrderService $service;

    public function __construct(PurchaseOrderService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('transaction.po.index',
         ['data' =>  $this->service->list()]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/po");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/po");
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
        return redirect("/po");
    }
}
