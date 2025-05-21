<?php

namespace App\Http\Controllers\Transaction\Production;

use App\Http\Controllers\Controller;
use App\Services\Transaction\ProductionCostService;
use Illuminate\Http\Request;

class ProductionCostController extends Controller
{
    private $service;
    public function __construct(ProductionCostService $service)
    {
        $this->service = $service;
    }
     public function index()
    {
        //
        return response()->view('transaction.production_cost.index',
        ['data' => $this->service->list()]
        );
    }

    public function active_deactive(Request $request)
    {
        $this->service->active_deactive($request);
        return redirect("/production_cost");
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/production_cost");
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
        return redirect("/production_cost");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/production_cost");
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
