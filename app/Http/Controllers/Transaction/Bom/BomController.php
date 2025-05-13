<?php

namespace App\Http\Controllers\Transaction\Bom;

use App\Services\Master\Bom\BomService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BomController
{
    
    private BomService $service;

    public function __construct(BomService $service)
    {
        $this->service = $service;
    }


    public function index(): Response
    {
        return response()->view('transaction.bom.index');
    }

    public function get_list_pageable(Request $request)
    {
        $data = $this->service->list_pageable($request);
        return response()->json([
            'draw' => intval($request->input('draw')), // Parameter dari DataTables
            'recordsTotal' => $data['recordsTotal'], // Total record tanpa filter
            'recordsFiltered' => $data['recordsFiltered'], // Total record setelah filter
            'data' => $data['data'], // Data untuk ditampilkan
        ]);
    }

     public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/bom");
    }

     public function edit_detail(Request $request)
    {
        return response()->view('transaction.bom.edit');
    }
}