<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\HelperCustom;
use Illuminate\Http\Request;
use App\Services\Transaction\PurchaseOrderService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Schema;

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
                $items = DB::table('trans_purchase_order')
                    ->where('id', $id)
                    ->orWhere('id', $id)
                    ->orWhere('id', $id)
                    ->get();
            }

            // Jika tidak ada items, coba tabel dengan nama berbeda
            if ($items->isEmpty()) {
                $possibleTables = [
                    'po_items',
                    'po_details',
                    'purchase_order_details',
                    'po_detail_items'
                ];

                foreach ($possibleTables as $table) {
                    if (Schema::hasTable($table)) {
                        $items = DB::table($table)
                            ->where('po_id', $id)
                            ->orWhere('id', $id)
                            ->orWhere('po_doc_id', $id)
                            ->get();
                        
                        if (!$items->isEmpty()) {
                            // \Log::info("Found items in table: " . $table);
                            break;
                        }
                    }
                }
            }

            // Format response dengan pengecekan property yang aman
            $formattedItems = $items->map(function ($item) {
                // Convert stdClass ke array untuk kemudahan akses
                $itemArray = (array) $item;
                
                return [
                    'id' => $itemArray['id'] ?? null,
                    'item_code' => $itemArray['item_code'] ?? $itemArray['code'] ?? $itemArray['product_code'] ?? '-',
                    'item_name' => $itemArray['item_name'] ?? $itemArray['name'] ?? $itemArray['product_name'] ?? $itemArray['description'] ?? '-',
                    'qty_ordered' => $itemArray['qty_ordered'] ?? $itemArray['qty'] ?? $itemArray['quantity'] ?? 0,
                    'unit' => $itemArray['unit'] ?? $itemArray['uom'] ?? $itemArray['unit_measure'] ?? '-',
                    'unit_price' => $itemArray['unit_price'] ?? $itemArray['price'] ?? $itemArray['cost'] ?? 0,
                    'total_price' => $itemArray['total_price'] ?? $itemArray['total'] ?? $itemArray['amount'] ?? 
                                   (($itemArray['qty_ordered'] ?? $itemArray['qty'] ?? 0) * ($itemArray['unit_price'] ?? $itemArray['price'] ?? 0)),
                    'delivery_date' => $itemArray['delivery_date'] ?? $itemArray['due_date'] ?? $itemArray['expected_date'] ?? null,
                    'status' => $itemArray['status'] ?? 'Pending',
                    'remarks' => $itemArray['remarks'] ?? $itemArray['notes'] ?? $itemArray['comment'] ?? null
                ];
            });

            // Log untuk debugging
            // \Log::info("Found " . $items->count() . " items for PO ID: " . $id);
            // \Log::info("Formatted items: " . json_encode($formattedItems->take(1))); // Log sample

            return response()->json([
                'success' => true,
                'message' => 'Items retrieved successfully',
                'data' => $formattedItems,
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
