<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerDeliveryScheduleController extends Controller
{
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/customer_delivery_schedule/css',
            'content' => 'transaction/inventory/customer_delivery_schedule/index',
            'script'  => 'transaction/inventory/customer_delivery_schedule/script',
        ];

        return view('transaction/inventory/customer_delivery_schedule/index', $data);
    }
}
