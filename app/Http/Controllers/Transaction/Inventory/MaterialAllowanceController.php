<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialAllowanceController extends Controller
{
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/material_allowance/css',
            'content' => 'transaction/inventory/material_allowance/index',
            'script'  => 'transaction/inventory/material_allowance/script',
        ];

        return view('transaction/inventory/material_allowance/index', $data);
    }
}
