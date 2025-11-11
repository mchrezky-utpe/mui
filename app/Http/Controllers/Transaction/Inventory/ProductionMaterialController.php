<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductionMaterialController extends Controller
{
    
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/production_material/css',
            'content' => 'transaction/inventory/production_material/index',
            'script'  => 'transaction/inventory/production_material/script',
        ];

        return view('transaction/inventory/production_material/index', $data);
    }
}
