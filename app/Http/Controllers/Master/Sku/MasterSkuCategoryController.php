<?php

namespace App\Http\Controllers\Master\Sku;

use App\Helpers\HelperCustom;
use App\Services\Master\Sku\MasterSkuCategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterSkuCategoryController
{

    private MasterSkuCategoryService $service;

    public function __construct(
        MasterSkuCategoryService $service,
    )
    { 
        $this->service = $service;
    }

    public function index(): Response
    {
        return response()
            ->view('master.sku_category.index',
             [
                'data' =>  $this->service->list()
            ]);
    }

    public function api_droplist()
    {
        $data = $this->service->droplist();
         return response()->json([
            'data' => $data
        ]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku-category");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-category");
    }

    
    public function get(Request $request, int $id)
    {
        $sku = $this->service->get($id);
        return response()->json([
            'data' => $sku
        ]);
    }

    public function edit(Request $request)
    {
        $this->service->edit($request);
        return redirect("/sku-category");
    }
}
