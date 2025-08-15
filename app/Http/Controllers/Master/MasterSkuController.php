<?php

namespace App\Http\Controllers\Master;

use App\Exports\SkuExport;
use App\Exports\SkuGeneralItemExport;
use App\Exports\SkuProductionMaterialExport;
use App\Helpers\HelperCustom;
use App\Models\MasterSku;
use App\Services\Master\MasterSkuService;
use App\Services\Master\MasterSkuTypeService;
use App\Services\Master\MasterSkuDetailService;
use App\Services\Master\MasterSkuModelService;
use App\Services\Master\MasterSkuUnitService;
use App\Services\Master\MasterSkuProcessService;
use App\Services\Master\MasterSkuPackagingService;
use App\Services\Master\MasterSkuBusinessService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class MasterSkuController
{

    private MasterSkuService $service;
    private MasterSkuTypeService $typeService;
    private MasterSkuBusinessService $businessService;

    public function __construct(
        MasterSkuService $service,
        MasterSkuDetailService $detailService,
        MasterSkuUnitService $unitService,
        MasterSkuModelService $modelService,
        MasterSkuTypeService $typeService,
        MasterSkuProcessService $processService,
        MasterSkuBusinessService $businessService,
        MasterSkuPackagingService $packagingService
    ) {
        $this->service = $service;
        // $this->detailService = $detailService;
        // $this->modelService = $modelService;
        // $this->unitService = $unitService;
        $this->typeService = $typeService;
        // $this->processService = $processService;
        // $this->packagingService = $packagingService;
        $this->businessService = $businessService;
    }

    public function index(): Response
    {
        return response()
            ->view(
                'master.sku_part_information.index',
                [
                    'data' =>  $this->service->list_part_information(),
                    'type' => $this->typeService->list(),
                    // 'detail' => $this->detailService->list(),
                    // 'unit' => $this->unitService->list(),
                    // 'model' => $this->modelService->list(),
                    // 'packaging' => $this->packagingService->list(),
                    // 'process' => $this->processService->list(),
                    'business' => $this->businessService->list()
                ]
            );
    }

    public function index_production_material(): Response
    {
        return response()
            ->view(
                'master.sku_production_material.index',
                [
                    'data' =>  $this->service->list_production_material_information(),
                    'type' => $this->typeService->list(),
                    // 'detail' => $this->detailService->list(),
                    // 'unit' => $this->unitService->list(),
                    // 'model' => $this->modelService->list(),
                    // 'packaging' => $this->packagingService->list(),
                    // 'process' => $this->processService->list(),
                    'business' => $this->businessService->list()
                ]
            );
    }

    public function index_general_item(): Response
    {
        return response()
            ->view(
                'master.sku_general_item.index',
                [
                    'data' =>  $this->service->list_general_information(),
                    'type' => $this->typeService->list(),
                    // 'detail' => $this->detailService->list(),
                    // 'unit' => $this->unitService->list(),
                    // 'model' => $this->modelService->list(),
                    // 'packaging' => $this->packagingService->list(),
                    // 'process' => $this->processService->list(),
                    'business' => $this->businessService->list()
                ]
            );
    }



    public function api_sku_part_information()
    {
        $data = $this->service->list_part_information();
         return response()->json([
            'data' => $data
        ]);
    }
    public function api_all_production_material()
    {
        $data = $this->service->list();
         return response()->json([
            'data' => $data
        ]);
    }
    public function api_all_general_item()
    {
        $data = $this->service->list();
         return response()->json([
            'data' => $data
        ]);
    }

    
    public function api_all_sku()
    {
        $data = $this->service->get_all_sku();
         return response()->json([
            'data' => $data
        ]);
    }
    

    public function get_code(Request $request)
    {
        $data = $this->service->generateCode($request->sku_type_id, $request->flag_sku_type);
        return response()->json([
            'data' => $data
        ]);
    }
    // public function get_code_production_material(Request $request)
    // {
    //     $data = $this->service->generateCode($request->sku_type_id, $request->flag_sku_type);
    //      return response()->json([
    //         'data' => $data
    //     ]);
    // }
    // public function get_code_general_item(Request $request)
    // {
    //     $data = $this->service->generateCode($request->sku_type_id, $request->flag_sku_type);
    //      return response()->json([
    //         'data' => $data
    //     ]);
    // }

    public function get_set_code()
    {
        $data = $this->service->get_set_code();
        return response()->json([
            'data' => $data
        ]);
    }
    // public function get_set_code_production_material()
    // {
    //     $data = $this->service->get_set_code();
    //      return response()->json([
    //         'data' => $data
    //     ]);
    // }
    // public function get_set_code_general_item()
    // {
    //     $data = $this->service->get_set_code();
    //      return response()->json([
    //         'data' => $data
    //     ]);
    // }

    public function add(Request $request)
    {
        $request->validate([
            'blob_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'val_area' => 'required|numeric',
            'val_weight' => 'required|numeric',
            'val_conversion' => 'required|numeric',
        ]);

        $data = $request->all();

        if ($request->hasFile('blob_image')) {
            $image = $request->file('blob_image');
            $folder = 'sku_images/' . now()->format('Y-m');
            
            // Simpan ke storage/app/public/sku_images/...
            $path = $image->store($folder, 'public');
            
            // Simpan path relatif tanpa 'public/' prefix
            $data['blob_image'] = $path;
        }

        $data['flag_inventory_register'] = $request->has('flag_inventory_register') ? 1 : 0;

        MasterSku::create($data);

        return redirect("/sku-part-information")->with('success', 'SKU berhasil ditambahkan!');
    }
    public function add_production_material(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku-production-material");
    }
    public function add_general_item(Request $request)
    {
        $this->service->add($request);
        return redirect("/sku-general-item");
    }

    // -------------------------------------------------------------------------------------------

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-part-information");
    }
    public function delete_general_item(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-general-item");
    }
    public function delete_production_material(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/sku-production-material");
    }

    // ------------------------------------------------------------------------

    public function get(Request $request, $id)
    {
        $sku = $this->service->get($id);
        return response()->json([
            'data' => $sku
        ]);
    }

    // -------------------------------------------------------------------------

    public function edit(Request $request)
    {
        $this->service->edit($request);
        return redirect("/sku-part-information");
    }
    public function edit_production_material(Request $request)
    {
        $this->service->edit($request);
        return redirect("/sku-production-material");
    }
    public function edit_general_item(Request $request)
    {
        $this->service->edit($request);
        return redirect("/sku-general-item");
    }

    // EXPORT XLSX

    public function export()
    {
        return Excel::download(new SkuExport, 'sku.xlsx');
    }

    public function export_production_material()
    {
        return Excel::download(new SkuProductionMaterialExport, 'sku_production_material.xlsx');
    }
    
    public function export_general_item()
    {
        return Excel::download(new SkuGeneralItemExport, 'sku_general_item.xlsx');
    }
    public function showImage($id)
    {
        $sku = \App\Models\MasterSku::findOrFail($id);

        if (!$sku->blob_image) {
            abort(404);
        }

        return response($sku->blob_image)->header('Content-Type', 'image/jpeg'); // atau sesuaikan dengan tipe gambar
    }
}
