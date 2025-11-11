<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/delivery_order/css',
            'content' => 'transaction/inventory/delivery_order/index',
            'script'  => 'transaction/inventory/delivery_order/script',
        ];

        return view('transaction/inventory/delivery_order/index', $data);
    }
}
