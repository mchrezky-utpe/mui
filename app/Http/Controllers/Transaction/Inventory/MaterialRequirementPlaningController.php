<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialRequirementPlaningController extends Controller
{
     
     public function index()
    {
         $data = [
            'css'     => 'transaction/inventory/material_requirement_planing/css',
            'content' => 'transaction/inventory/material_requirement_planing/index',
            'script'  => 'transaction/inventory/material_requirement_planing/script',
        ];

        return view('transaction/inventory/material_requirement_planing/index', $data);
    }
}
