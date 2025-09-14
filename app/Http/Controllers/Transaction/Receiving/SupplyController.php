<?php

namespace App\Http\Controllers\Transaction\Receiving;

use App\Services\Transaction\Receiving\SupplyService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupplyController
{

    private SupplyService $service;

    public function __construct(SupplyService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view(
            'transaction.receiving.supply.index',
            ['data' =>     $this->service->list()]
        );
    }

    public function api_item(Request $request)
    {
        $data = $this->service->get_item($request);
        return response()->json([
            'data' => $data
        ]);
    }
    

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/supply");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/supply");
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
        return redirect("/supply");
    }
}
