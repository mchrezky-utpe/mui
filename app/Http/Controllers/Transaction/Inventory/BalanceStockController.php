<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BalanceStockController extends Controller
{
    
    
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/balance_stock/css',
            'content' => 'transaction/inventory/balance_stock/index',
            'script'  => 'transaction/inventory/balance_stock/script',
        ];

        return view('transaction/inventory/balance_stock/index', $data);
    }
}
