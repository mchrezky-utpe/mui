<?php

namespace App\Http\Controllers\Transaction;

use App\Services\Transaction\SkuPricelistService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SkuPricelistController
{

    private SkuPricelistService $service;

    public function __construct(SkuPricelistService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('transaction.sku_pricelist.index');
    }

    
    public function getAllPagination(Request $request)
    {
        $data = $this->service->list_pagination($request);
        return response()->json([
            'draw' => intval($request->input('draw')), // Parameter dari DataTables
            'recordsTotal' => $data['recordsTotal'], // Total record tanpa filter
            'recordsFiltered' => $data['recordsFiltered'], // Total record setelah filter
            'data' => $data['data'], // Data untuk ditampilkan
        ]);
    }

    public function getHistory(Request $request)
    {     
      $data = $this->service->getHistory($request);
         return response()->json([
            'data' => $data
        ]);
    }


    public function get_api_by(Request $request)
    {
        $data = $this->service->get_by($request);
         return response()->json([
            'data' => $data
        ]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku-pricelist");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-pricelist");
    }
    
    public function get(Request $request, int $id)
    {
        $data = $this->service->get($id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function edit(Request $request)
    {
        $this->service->edit($request);
        return redirect("/sku-pricelist");
    }
}
