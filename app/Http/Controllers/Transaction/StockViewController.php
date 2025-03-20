<?php
namespace App\Http\Controllers\Transaction;


use App\Helpers\HelperCustom;
use App\Services\Transaction\StockViewService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StockViewController
{

    private StockViewService $service;

    public function __construct(StockViewService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('transaction.stock_view.index',
         ['data' =>  $this->service->list()]);
    }

    public function api_all(Request $request)
    {
        $data = $this->service->get_all($request);
        return response()->json([
            'draw' => intval($request->input('draw')), 
            'recordsTotal' => $data['recordsTotal'],
            'recordsFiltered' => $data['recordsFiltered'],
            'data' => $data['data'],
        ]);
    }

    public function sync(Request $request)
    {
        $this->service->sync($request);
        return response()->json([ 'status' => 'ok' ]);
    }
}