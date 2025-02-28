<?php

namespace App\Http\Controllers\Transaction;

use App\Services\Transaction\SdoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SdoController
{

    private SdoService $service;

    public function __construct(SdoService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view(
            'transaction.sdo.index',
            ['data' =>     $this->service->list()]
        );
    }


    public function send_to_edi(Request $request)
    {
        $this->service->send_to_edi($request);
        return redirect("/sdo");
    }


    public function reschedule(Request $request)
    {
        $this->service->reschedule($request);
        return redirect("/sdo");
    }


    public function pull_back(Request $request)
    {
        $this->service->pull_back($request);
        return redirect("/sdo");
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sdo");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sdo");
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
        return redirect("/sdo");
    }
}
