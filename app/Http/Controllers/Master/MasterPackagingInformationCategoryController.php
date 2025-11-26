<?php

namespace App\Http\Controllers\Master; 

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\NumberGenerator;
use Illuminate\Support\Str;
use App\Models\Master\PackagingInformation\PackagingInformationCategory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MasterPackagingInformationCategoryController
{


    public function index(): Response
    {
        return response()
            ->view('master.packaging_information_category.index', ['data' =>  null   ]);
    }

    public function get_all(Request $request){
        
        $start = $request->input('start');
        $length = $request->input('length'); 
        $search = $request->input('search.value');
        $query = DB::table('vw_app_list_mst_packaging_infromation_category');

        $recordsTotal = $query->count();
        $recordsFiltered = $query->count();
        
        if($length > 0){        
            $data = $query->limit($length)->offset($start)->get();
        }else{
            $data = $query->get();
        }

        $data = [
            'data' =>  $data,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];

        return response()->json([
            'draw' => intval($request->input('draw')), // Parameter dari DataTables
            'recordsTotal' => $data['recordsTotal'], // Total record tanpa filter
            'recordsFiltered' => $data['recordsFiltered'], // Total record setelah filter
            'data' => $data['data'], // Data untuk ditampilkan
        ]);
    }
    public function add(Request $request)
    {

        DB::beginTransaction();
    
        try {
            $doc_num_generated = NumberGenerator::generateNumber('mst_packaging_information_category', 'PCC');
           
            $data = [
                'type_id' =>  $request->type_id,
                'description' => $request->description,
                'model_id' =>  $request->model_id,
                'category_size' =>  $request->category_size,
                'unit_id' =>  $request->unit_id,
                'total_stock' =>  $request->total_stock,
                'prefix' => $doc_num_generated['doc_num'],
                'counter' => $doc_num_generated['doc_counter'],
                'generated_id' => Str::uuid()->toString(),
                'flag_active' => 1
            ];
            PackagingInformationCategory::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return redirect("/packaging-information-category");
    }

    public function delete(Request $request, int $id)
    {
        DB::beginTransaction();

        try {
            $data = PackagingInformationCategory::where('id', $id)->firstOrFail();

            $data->flag_active = 0;
            $data->deleted_at = Carbon::now();
            $data->deleted_by = Auth::id();
            $data->save();

            DB::commit();

        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            dd($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus.',
                'error' => $e->getMessage(),
            ], 500);
        }
        return redirect("/packaging-information-category");
    }
    
    public function get(Request $request, int $id)
    {
        $query = DB::table('mst_packaging_information_category');
        $query->where('id', [$id]);

        $data = $query->first();
        return response()->json([
            'data' => $data
        ]);
    }

    public function edit(Request $request)
    {
        $data = PackagingInformationCategory::where('id', $request->id)->firstOrFail();
        $data->type_id = $request->type_id;
        $data->description = $request->description;
        $data->model_id = $request->model_id;
        $data->category_size = $request->category_size;
        $data->unit_id = $request->unit_id;
        $data->total_stock = $request->total_stock;
        $data->save();
        return redirect("/packaging-information-category");
    }

}
