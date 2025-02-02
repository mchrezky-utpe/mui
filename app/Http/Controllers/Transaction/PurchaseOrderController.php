<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\HelperCustom;
use App\Models\Transaction\PurchaseOrdePrintHdVw;
use App\Models\Transaction\PurchaseOrdePrintDtVw;
use App\Services\Transaction\PurchaseOrderService;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class PurchaseOrderController
{

    private PurchaseOrderService $service;

    public function __construct(PurchaseOrderService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('transaction.po.index',
         ['data' =>  $this->service->list()]);
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
    

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/po");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/po");
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
        return redirect("/po");
    }


    public function print(Request $request, int $id)
    {
        // dd($request);
        $response = $this->service->print($id);
  
        return view('transaction.po.print_po', $response);
    }
    

}
