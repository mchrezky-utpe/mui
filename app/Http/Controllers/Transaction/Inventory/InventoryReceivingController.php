<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Helpers\HelperCustom;
use App\Services\Transaction\Inventory\InventoryReceivingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InventoryReceivingController

{

    private InventoryReceivingService $service;

    public function __construct(InventoryReceivingService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('transaction.inventory.inventory_receiving.index',
         ['data' =>  $this->service->list()]);
    }
    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/inventory-receiving");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/inventory-receiving");
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
        return redirect("/inventory-receiving");
    }
}
