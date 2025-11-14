<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionHistoryController extends Controller
{
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/transaction_history/css',
            'content' => 'transaction/inventory/transaction_history/index',
            'script'  => 'transaction/inventory/transaction_history/script',
        ];

        return view('transaction/inventory/transaction_history/index', $data);
    }
}
