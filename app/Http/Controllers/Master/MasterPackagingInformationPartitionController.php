<?php

namespace App\Http\Controllers\Master; 

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\NumberGenerator;
use Illuminate\Support\Str;
use App\Models\Master\PackagingInformation\PackagingInformationPartition;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MasterPackagingInformationPartitionController
{


    public function index(): Response
    {
        return response()
            ->view('master.packaging_information_partition.index', ['data' =>  null   ]);
    }

    public function get_all(Request $request){
        
        $start = $request->input('start');
        $length = $request->input('length'); 
        $search = $request->input('search.value');
        $query = DB::table('vw_app_list_mst_packaging_infromation_partition');

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
            $doc_num_generated = NumberGenerator::generateNumber('mst_packaging_information_partition', 'PCP');
     
            $data = [
                'type_id' =>  $request->type_id,
                'description' => $request->description,
                'size' =>  $request->size,
                'capacity' =>  $request->capacity,
                'prefix' => $doc_num_generated['doc_num'],
                'counter' => $doc_num_generated['doc_counter'],
                'generated_id' => Str::uuid()->toString(),
                'flag_active' => 1
            ];
            PackagingInformationPartition::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return redirect("/packaging-information-partition");
    }

    public function delete(Request $request, int $id)
    {
        DB::beginTransaction();

        try {
            $data = PackagingInformationPartition::where('id', $id)->firstOrFail();

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
        return redirect("/packaging-information-partition");
    }
    
    public function get(Request $request, int $id)
    {
        $query = DB::table('mst_packaging_information_partition');
        $query->where('id', [$id]);

        $data = $query->first();
        return response()->json([
            'data' => $data
        ]);
    }

    public function edit(Request $request)
    {
        $data = PackagingInformationPartition::where('id', $request->id)->firstOrFail();
        $data->type_id = $request->type_id;
        $data->description = $request->description;
        $data->size = $request->size;
        $data->capacity = $request->capacity;
        $data->save();
        return redirect("/packaging-information-partition");
    }

}
