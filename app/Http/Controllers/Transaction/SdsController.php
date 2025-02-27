<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\HelperCustom;
use App\Services\Transaction\SdsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class SdsController
{

    private SdsService $service;

    public function __construct(SdsService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('transaction.sds.index',
         ['data' => 
         $this->service->list()
        ]);
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
    
    
    public function send_to_edi(Request $request)
    {
        $this->service->send_to_edi($request);
        return redirect("/sds");
    }
    
    
    public function reschedule(Request $request)
    {
        $this->service->reschedule($request);
        return redirect("/sds");
    }
    
    
    public function pull_back(Request $request)
    {
        $this->service->pull_back($request);
        return redirect("/sds");
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sds");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sds");
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
        return redirect("/sds");
    }
}
