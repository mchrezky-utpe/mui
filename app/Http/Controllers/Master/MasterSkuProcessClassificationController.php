<?php

namespace App\Http\Controllers\Master;

use App\Services\Master\MasterSkuProcessClassificationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterSkuProcessClassificationController
{

    private MasterSkuProcessClassificationService $service;
    private $route = "/sku-process-classification";

    public function __construct(MasterSkuProcessClassificationService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('master.sku_process_classification.index', [
            // 'data' =>  $this->service->list()
        ]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect($this->route);
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect($this->route);
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
        return redirect($this->route);
    }

    public function paginate(Request $request) {
        $data = $this->service->paginate($request);
        return response()->json([
            'draw' => intval($request->input('draw')), // Parameter dari DataTables
            'recordsTotal' => $data['recordsTotal'], // Total record tanpa filter
            'recordsFiltered' => $data['recordsFiltered'], // Total record setelah filter
            'data' => $data['data'], // Data untuk ditampilkan
        ]);
    }   
}
