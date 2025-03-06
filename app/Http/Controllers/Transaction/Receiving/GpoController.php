<?php

namespace App\Http\Controllers\Transaction\Receiving;

use App\Services\Transaction\Receiving\GpoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GpoController
{

    private GpoService $service;

    public function __construct(GpoService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view(
            'transaction.receiving.gpo.index',
            ['data' =>     $this->service->list()]
        );
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
        $data = $this->service->get_item($request);
        return response()->json([
            'data' => $data
        ]);
    }

    public function receive(Request $request)
    {
        $this->service->receive($request);
        return redirect("/gpo");
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/gpo");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/gpo");
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
        return redirect("/gpo");
    }
}
