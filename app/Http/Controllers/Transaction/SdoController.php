<?php

namespace App\Http\Controllers\Transaction;

use App\Services\Transaction\SdoService;
use App\Exports\SdoExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SdoController
{

    private SdoService $service;

    public function __construct(SdoService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('transaction.sdo.index');
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

    public function api_droplist(Request $request)
    {
        $data = $this->service->get_droplist($request);
        return response()->json([
            'data' => $data
        ]);
    }
    
    public function api_item_by(Request $request)
    {
        $data = $this->service->get_item($request);
        return response()->json([
            'data' => $data
        ]);
    }

    public function receive(Request $request)
    {
        $this->service->receive($request);
        return redirect("/sdo");
    }


    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sdo");
    }

    public function detail(Request $request)
    {
        $data = $this->service->get($request->id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function edit(Request $request)
    {
        $this->service->edit($request);
        return redirect("/sdo");
    }
    
    public function export()
    {
        return Excel::download(new SdoExport, 'sdo_export.xlsx');
    }
}
