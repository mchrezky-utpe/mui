<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockOpeningController extends Controller
{
    
     public function index()
    {
         $data = [
            'title'   => 'stock_opening',
            'css'     => 'transaction/inventory/stock_opening/css',
            'content' => 'transaction/inventory/stock_opening/index',
            'script'  => 'transaction/inventory/stock_opening/script',
        ];

        return view('transaction/inventory/stock_opening/index', $data);
    }
}
