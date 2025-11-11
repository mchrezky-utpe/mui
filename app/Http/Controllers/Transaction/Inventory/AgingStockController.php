<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgingStockController extends Controller
{
     
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/aging_stock/css',
            'content' => 'transaction/inventory/aging_stock/index',
            'script'  => 'transaction/inventory/aging_stock/script',
        ];

        return view('transaction/inventory/aging_stock/index', $data);
    }

}
