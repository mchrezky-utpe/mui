<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Master\MasterGeneralCurrencyService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterGeneralCurrencyController
{

    private MasterGeneralCurrencyService $service;

    public function __construct(MasterGeneralCurrencyService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('master.general_currency.index',
         ['data' =>  $this->service->list()]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/general-currency");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/general-currency");
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
        return redirect("/general-currency");
    }
}
