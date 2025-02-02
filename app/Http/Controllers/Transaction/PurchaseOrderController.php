<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\HelperCustom;
use App\Models\Transaction\PurchaseOrder;
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
    //     $header = PurchaseOrder::where('id', $request->id)->firstOrFail();
    $header = DB::table('trans_purchase_order')
    ->select(
        'trans_purchase_order.id',
        'trans_purchase_order.trans_date',
        'trans_purchase_order.manual_id',
        'trans_purchase_order.doc_num',
        'trans_purchase_order.revision',
        'mst_general_currency.description as currency',
        'mst_general_terms.description as terms',
        'trans_purchase_request.doc_num as purchase',
        'mst_general_department.description as department',
        'trans_purchase_order.trans_date',
        'trans_purchase_order.description',
        'mst_person_supplier.description as supplier_name',
        'mst_person_supplier.address_01',
        'mst_person_supplier.phone_01',
        'mst_person_supplier.fax_01',
        'mst_person_supplier.email_01',
    )
    ->leftJoin('mst_person_supplier', 'trans_purchase_order.prs_supplier_id', '=', 'mst_person_supplier.id')
    ->leftJoin('mst_general_currency', 'trans_purchase_order.gen_currency_id', '=', 'mst_general_currency.id')  
    ->leftJoin('mst_general_terms', 'trans_purchase_order.gen_terms_detail_id', '=', 'mst_general_terms.id')  
    ->leftJoin('trans_purchase_request', 'trans_purchase_order.purchase_request_id', '=', 'trans_purchase_request.id') 
    ->leftJoin('mst_general_department', 'trans_purchase_order.gen_department_id', '=', 'mst_general_department.id') 
    ->where('trans_purchase_order.id', '=', $id)
    ->first();
    $data = DB::table('trans_purchase_order_detail')
    ->select('trans_purchase_order_detail.*',
    'trans_purchase_order.trans_date as req_date',
    )
    ->leftJoin('trans_purchase_order','trans_purchase_order_detail.trans_po_id','=','trans_purchase_order.id')
    ->where('trans_purchase_order_detail.trans_po_id', '=', $header->id)
    ->get();
        // Lakukan sesuatu dengan data yang diambil, misalnya, render view untuk print
        return view('transaction.po.print_po', compact('header', 'data'));
    }
    
}
