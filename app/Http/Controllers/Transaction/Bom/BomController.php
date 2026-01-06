<?php

namespace App\Http\Controllers\Transaction\Bom;

use App\Services\Master\Bom\BomService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BomController
{
    
    private BomService $service;

    public function __construct(BomService $service)
    {
        $this->service = $service;
    }


    public function index(): Response
    {
        return response()->view('transaction.bom.index');
    }

    public function get_item_material(Request $request){
        
        $start = $request->input('start');
        $length = $request->input('length'); 
        $search = $request->input('search.value');
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
        $columns = $request->input('columns');

        $query = DB::table('vw_app_list_trans_sku_pricelist');
        
         $query->where('flag_sku_type','=', 2);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('vw_app_list_trans_sku_pricelist.sku_name', 'like', '%' . $search . '%')
                    ->orWhere('vw_app_list_trans_sku_pricelist.sku_id', 'like', '%' . $search . '%');
            });
        }

        $recordsTotal = $query->count();

        $recordsFiltered = $query->count();

        $data = $query->get();
        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' =>  $recordsFiltered
        ];
    }

    public function add_index(): Response
    {
        return response()->view('transaction.bom.add');
    }


    public function get_list_pageable(Request $request)
    {
        $data = $this->service->list_pageable($request);
        return response()->json([
            'draw' => intval($request->input('draw')), // Parameter dari DataTables
            'recordsTotal' => $data['recordsTotal'], // Total record tanpa filter
            'recordsFiltered' => $data['recordsFiltered'], // Total record setelah filter
            'data' => $data['data'], // Data untuk ditampilkan
        ]);
    }

     public function add(Request $request)
    {
        $this->service->add($request);
        return redirect("/bom");
    }

     public function edit_detail(Request $request, int $id)
    {
        $data =  $this->service->get_detail($id);
        return response()->view('transaction.bom.edit',['data' => $data]);
    }

     public function do_edit_detail(Request $request)
    {
        dd($request);
        $bom_id = $request->bom_id;
        $data = json_decode($request->data, true);
        $this->service->do_edit_detail($bom_id,$data);
        return redirect("/bom");
    }
    

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect("/bom");
    }
    
    public function get_detail_bom(Request $request, $id)
    {
    $query = DB::table('vw_app_list_mst_sku_bom_detail');
        
        $query->where('bom_id', $id);
    
        $data = $query->get();
        return response()->json([
            'data' => $data
        ]);
    }
    
}