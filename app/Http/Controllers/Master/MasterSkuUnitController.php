<?php

namespace App\Http\Controllers\Master;

use App\Services\Master\MasterSkuUnitService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterSkuUnitController
{

    private MasterSkuUnitService $service;

    public function __construct(MasterSkuUnitService $service)
    {
        $this->service = $service;
    }

/**
     * @OA\Post(
     *     path="/api/sku-unit",
     *     summary="Create a sku unit",
     *     tags={"Sku Unit"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"description", "prefix"},
     *             @OA\Property(property="description", type="string", example="BAG"),
     *             @OA\Property(property="prefix", type="string", example="BAG"),
     *             @OA\Property(property="manual_id", type="integer", nullable=true, example=null)
     *         )
     *     )
     *     )
     * )
     */
    public function api_add(Request $request)
    {
        $this->service->add($request);
        return response()->json([
            'message' => 'Save Sucesssfuly'
        ]);
    }

    public function api_edit(Request $request, int $id)
    {
        $this->service->edit($request, $id);
        return response()->json([
            'message' => 'Edit Sucesssfuly'
        ]);
    }

    public function api_delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return response()->json([
            'message' => 'Delete Sucesssfuly'
        ]);
    }



    public function index(): Response
    {
        return response()->view('master.sku_unit.index', ['data' =>  $this->service->list()->sortBy('manual_id')]);
    }

    
/**
 * @OA\Get(
 *     path="/api/items",
 *     summary="Get list of sku unit",
 *     tags={"Sku Unit"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *             @OA\Items(ref="#/components/schemas/SkuUnit")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */
    public function api_all()
    {
        $data = $this->service->list();
         return response()->json([
            'data' => $data
        ]);
    }

    public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku-unit");
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-unit");
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
        return redirect("/sku-unit");
    }

    public function api_droplist()
    {
        $data = $this->service->droplist();
         return response()->json([
            'data' => $data
        ]);
    }
}
