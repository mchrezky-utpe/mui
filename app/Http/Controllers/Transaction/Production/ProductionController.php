<?php

namespace App\Http\Controllers\Transaction\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Transaction\ProductionService as TransactionProductionService;

class ProductionController extends Controller
{
    /**
    //  * @var ProductionService
     */
    private $service;
    public function __construct(TransactionProductionService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->view('transaction.production_cycle.index',
            ['data' => $this->service->list()]
        );
    }

    /**
     * Add new production record (POST)
     */
    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/production_cycle");
    }

    /**
     * Get single production record (API)
     */
    public function get(Request $request, int $id)
    {
        $data = $this->service->get($id);
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Edit production record (POST)
     */
    public function edit(Request $request)
    {
        $this->service->edit($request);
        return redirect("/production_cycle");
    }

    /**
     * Export to PDF
     */
    // public function exportPdf()
    // {
    //     $data = TransactionProductionCycle::where('flag_active', 1)->get();
    
    //     $pdf = Pdf::loadView('transaction.production_cycle.pdf', ['data' => $data]);
    
    //     return $pdf->download('production-cycle-list.pdf');
    // }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Implementasi alternatif RESTful
        // $this->add($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Implementasi alternatif RESTful
        // return $this->get(request(), $id);
    }

    /**
     * Delete production record (POST)
     */
    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/production_cycle");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Implementasi alternatif RESTful
        // $request->merge(['id' => $id]);
        // $this->edit($request);
    }
}