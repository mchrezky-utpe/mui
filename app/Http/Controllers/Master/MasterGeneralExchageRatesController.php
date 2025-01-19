<?php

namespace App\Http\Controllers\Master;

// use App\Http\Controllers\Controller;
use App\Helpers\HelperCustom;
use App\Services\Master\MasterGeneralExchangeRatesService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterGeneralExchageRatesController
//  extends Controller
{
    private MasterGeneralExchangeRatesService $service;

    public function __construct(MasterGeneralExchangeRatesService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('master.general_exchange_rates.index',
         ['data' =>  $this->service->list()]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/general-exchange-rates");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/general-exchange-rates");
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
        return redirect("/general-exchange-rates");
    }
}
