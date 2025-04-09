<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\HelperCustom;
use Illuminate\Http\Request;
use App\Services\Transaction\PurchaseOrderService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;

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
    
    public function api_droplist(Request $request)
    {
        $data = $this->service->get_droplist($request);
        return response()->json([
            'data' => $data
        ]);
    }
    
    public function api_item_by(Request $request)
    {
        $data = $this->service->get_item_by($request);
        return response()->json([
            'data' => $data
        ]);
    }

    public function upload(Request $request)
    {
        $this->service->upload($request);
        return redirect("/po");
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

    public function generatePDF($id)
    {
        $po = PurchaseOrder::with('supplier')->findOrFail($id); // Tambahkan relasi supplier juga
    
        // Dummy data items, karena tidak ambil dari DB (belum ada relasi)
        $items = [
            [
                'item_code' => null,
                'item_name' => 'FR BODY KIT-SILVER',
                'spe_code' => null,
                'qty' => 1,
                'unit' => 'PCS',
                'price' => 191800,
                'amount' => 191800,
                'req_date' => now()->format('Y-m-d')
            ]
        ];
    
        // Ganti karakter ilegal
        $filename = 'PO-' . str_replace(['/', '\\'], '-', $po->doc_num) . '.pdf';
    
        $pdf = Pdf::loadView('transaction.po.pdf', compact('po', 'items'));
        return $pdf->download($filename);
    }
    
    

}
