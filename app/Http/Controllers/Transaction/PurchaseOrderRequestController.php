<?php

namespace App\Http\Controllers\Transaction;

use App\Services\Transaction\PurchaseOrderRequestService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PurchaseOrderRequestController
{
    
    private PurchaseOrderRequestService $service;

    public function __construct(PurchaseOrderRequestService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('transaction.pr.index',
         ['data' =>  $this->service->list()]);
    }


    public function index_detail(): Response
    {
        return response()->view('transaction.pr.index_detail');
    }

    public function api_all(Request $request)
    {
        $data = $this->service->get_all($request);
        return response()->json([
            'draw' => intval($request->input('draw')), // Parameter dari DataTables
            'recordsTotal' => $data['recordsTotal'], // Total record tanpa filter
            'recordsFiltered' => $data['recordsFiltered'], // Total record setelah filter
            'data' => $data['data'], // Data untuk ditampilkan
        ]);
    }

    public function api_detail_all(Request $request)
    {
        $data = $this->service->get_detail_all($request);
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
        return redirect("/pr");
    }

    public function add_po(Request $request){
        $this->service->add_po($request);
        return redirect("/pr");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/pr");
    }
    
    public function get(/*Request $request,*/ int $id)
    {
        $data = $this->service->get($id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function edit(Request $request)
    {
        $this->service->edit($request);
        return redirect("/pr");
    }
}
