<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerReturnController extends Controller
{
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/customer_return/css',
            'content' => 'transaction/inventory/customer_return/index',
            'script'  => 'transaction/inventory/customer_return/script',
        ];

        return view('transaction/inventory/customer_return/index', $data);
    }
}
