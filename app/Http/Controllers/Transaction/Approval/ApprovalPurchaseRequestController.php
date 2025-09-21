<?php

namespace App\Http\Controllers\Transaction\Approval;

use App\Helpers\HelperCustom;
use App\Services\Transaction\Approval\ApprovalPurchaseRequestService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApprovalPurchaseRequestController

{
    private ApprovalPurchaseRequestService $service;

    public function __construct(ApprovalPurchaseRequestService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view(
            'transaction.approval.purchase_request.index', 
             ['data' =>  $this->service->list()]
        );
    }

       public function api_all(Request $request)
    {
        $data = $this->service->list_pagination($request);
        return response()->json([
            'draw' => intval($request->input('draw')), // Parameter dari DataTables
            'recordsTotal' => $data['recordsTotal'], // Total record tanpa filter
            'recordsFiltered' => $data['recordsFiltered'], // Total record setelah filter
            'data' => $data['data'], // Data untuk ditampilkan
        ]);
    }

    public function apporve(Request $request)
    {
        $this->service->approve($request);
        return redirect("/approval-pr");
    }
    
    public function deny(Request $request)
    {
        $this->service->deny($request);
        return redirect("/approval-pr");
    }
    
    public function hold(Request $request)
    {
        $this->service->hold($request);
        return redirect("/approval-pr");
    }

    public function getItem(Request $request, int $pr_id){
        $data = $this->service->getItem($pr_id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function deny_item(Request $request)
    {
        $this->service->deny_item($request);
        return response()->json([
            'data' => "OK",
        ]);
    }

    public function hold_item(Request $request)
    {
        $this->service->hold_item($request);
        return response()->json([
            'data' => "OK",
        ]);
    }

}
