<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockViewController extends Controller
{
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/stock_view/css',
            'content' => 'transaction/inventory/stock_view/index',
            'script'  => 'transaction/inventory/stock_view/script',
        ];

        return view('transaction/inventory/stock_view/index', $data);
    }
}
