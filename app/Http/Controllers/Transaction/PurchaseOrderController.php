<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Services\Transaction\PurchaseOrderService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Schema;
use App\Models\Transaction\PurchaseOrdePrintDtVw;
use App\Models\Transaction\PurchaseOrdePrintHdVw;

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


    public function index_detail(): Response
    {
        return response()->view('transaction.po.index_detail');
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
        $po = PurchaseOrdePrintHdVw::where('id', $id)->first();
        $items = PurchaseOrdePrintDtVw::where('trans_po_id', $id)->get();
        
        // dd($po);
        $filename = 'PO-' . str_replace(['/', '\\'], '-', $po->po_number) . '.pdf';
    
        $pdf = Pdf::loadView('transaction.po.pdf', compact('po', 'items'));
        return  $pdf->stream($filename);
    }

    public function getItems($id)
    {
        try {
            // Log untuk debugging
            // \Log::info("Getting PO items for ID: " . $id);
            
            // Validasi ID
            if (!$id || !is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid PO ID',
                    'data' => []
                ], 400);
            }

            // Cari PO berdasarkan ID
            $po = PurchaseOrder::find($id);
            if (!$po) {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order not found',
                    'data' => []
                ], 404);
            }

            // METODE 1: Jika menggunakan Eloquent Relationship
            if (method_exists($po, 'items')) {
                $items = $po->items;
            }
            // METODE 2: Jika menggunakan Query Builder langsung
            else {
                // Sesuaikan nama tabel dengan database Anda
                $items = DB::table('vw_app_list_trans_po_dt')
                    ->where('trans_po_id', $id)
                    ->get();
            }

            // Jika tidak ada items, coba tabel dengan nama berbeda

            // Log untuk debugging
            // \Log::info("Found " . $items->count() . " items for PO ID: " . $id);
            // \Log::info("Formatted items: " . json_encode($formattedItems->take(1))); // Log sample

            return response()->json([
                'success' => true,
                'message' => 'Items retrieved successfully',
                'data' => $items,
                'total' => $items->count()
            ]);

        } catch (\Exception $e) {
            // Log error lengkap
            // \Log::error("Error getting PO items for ID: " . $id);
            // \Log::error("Error message: " . $e->getMessage());
            // \Log::error("Stack trace: " . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving items: ' . $e->getMessage(),
                'data' => [],
                'debug_info' => [
                    'po_id' => $id,
                    'error_line' => $e->getLine(),
                    'error_file' => basename($e->getFile())
                ]
            ], 500);
        }
    }
    
    

}
