<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Master\MasterSkuProcessTypeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterSkuProcessTypeController
{

    private MasterSkuProcessTypeService $service;
    private $route = "/sku-process-type";

    public function __construct(MasterSkuProcessTypeService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('master.sku_process_type.index', [
            'data' =>  $this->service->list()
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
        $data = $this->service->pagination_sku_process_type($request);
        return response()->json([
            'draw' => intval($request->input('draw')), // Parameter dari DataTables
            'recordsTotal' => $data['recordsTotal'], // Total record tanpa filter
            'recordsFiltered' => $data['recordsFiltered'], // Total record setelah filter
            'data' => $data['data'], // Data untuk ditampilkan
        ]);
    }

    public function api_name() {
        $data = $this->service->get_all_name();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
