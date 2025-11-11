<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceivingController extends Controller
{
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/receiving/css',
            'content' => 'transaction/inventory/receiving/index',
            'script'  => 'transaction/inventory/receiving/script',
        ];

        return view('transaction/inventory/receiving/index', $data);
    }
}
