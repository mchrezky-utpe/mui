<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Services\Master\MasterPersonEmployeeService;
// use App\Http\Controllers\Master\MasterPersonEmployeeService;
use App\Models\MasterPersonEmployee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MasterPersonEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private  $service;
    public function __construct(MasterPersonEmployeeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->view('master.person_employee.index',
        ['data' => $this->service->list()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/person-employee");
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

    public function get(Request $request, int $id)
    {
        $data = $this->service->get($id);
        return response()->json([
            'data' => $data
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $this->service->edit($request);
        return redirect("/person-employee");
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
    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/person-employee");
    }

    public function exportPdf()
    {
        $data = MasterPersonEmployee::all();
    
        $pdf = Pdf::loadView('master.person_employee.pdf', ['data' => $data]);
    
        return $pdf->download('person-employee-list.pdf');
    }
}
