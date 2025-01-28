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
        return response()->view('transaction.inventory_receiving.index');
        // ,
        //  ['data' =>  $this->service->list()]);
    }
}
