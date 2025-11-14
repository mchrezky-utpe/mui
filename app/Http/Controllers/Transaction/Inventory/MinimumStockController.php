<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MinimumStockController extends Controller
{
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/minimum_stock/css',
            'content' => 'transaction/inventory/minimum_stock/index',
            'script'  => 'transaction/inventory/minimum_stock/script',
        ];

        return view('transaction/inventory/minimum_stock/index', $data);
    }
}
