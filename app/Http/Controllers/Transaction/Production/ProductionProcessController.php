<?php

namespace App\Http\Controllers\Transaction\Production;

use App\Http\Controllers\Controller;
use App\Services\Transaction\ProductionProcessService;
use Illuminate\Http\Request;

class ProductionProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $service;
    public function __construct(ProductionProcessService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        //
        return response()->view('transaction.production_process.index',
        ['data' => $this->service->list()]
    );
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/production_process");
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
        return redirect("/production_process");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/production_process");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
