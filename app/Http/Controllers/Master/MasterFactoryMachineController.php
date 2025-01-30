<?php

namespace App\Http\Controllers\Master;

use App\Helpers\HelperCustom;
use App\Services\Master\MasterFactoryMachineService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterFactoryMachineController
{

    private MasterFactoryMachineService $service;

    public function __construct(MasterFactoryMachineService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()->view('master.factory_machine.index',
         ['data' =>  $this->service->list()]);
    }
    public function index2(): Response
    {
        return response()->view('master.factory_machine.index2',
         ['data' =>  $this->service->list2()]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/factory-machine");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/factory-machine");
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
        return redirect("/factory-machine");
    }
    public function hapus(Request $request, int $id)
    {
        $this->service->hapus($id);
        return redirect("/factory-machine/index2");
    }
    public function restore(Request $request, int $id)
    {
        $this->service->restore($id);
        return redirect("/factory-machine/index2");
    }
}
