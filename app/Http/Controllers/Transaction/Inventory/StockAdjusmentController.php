<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockAdjusmentController extends Controller
{
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/stock_adjusment/css',
            'content' => 'transaction/inventory/stock_adjusment/index',
            'script'  => 'transaction/inventory/stock_adjusment/script',
        ];

        return view('transaction/inventory/stock_adjusment/index', $data);
    }
}
