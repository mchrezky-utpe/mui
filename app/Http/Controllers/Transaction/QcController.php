<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Helpers\NumberGenerator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\QualityControlCheck;
use App\Models\Transaction\QualityControlCheckDetail;
use Carbon\Carbon;

class QcController
{ 
    public function index(): Response
    {
        return response()->view('transaction.qc.index');
    }

    public function get_data_all(Request $request){
        
        $start = $request->input('start');
        $length = $request->input('length'); 
        $search = $request->input('search.value');
        $query = DB::table('vw_app_list_trans_qc_list');

        $recordsTotal = $query->count();
        $recordsFiltered = $query->count();
        
        if ($request->start_date != null && $request->end_date != null) {
            $query->whereBetween('checking_date', [$request->start_date, $request->end_date]);
        }

        if($request->flag_checking_type != null){
            $query->where('flag_checking_type', $request->flag_checking_type);
        }
        
        if($length > 0){        
            $data = $query->limit($length)->offset($start)->orderBy('doc_num','DESC')->get();
        }else{
            $data = $query->sortBy('doc_num')->get();
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

    public function add(): Response
    {
        return response()->view('transaction.qc.add');
    }

    public function get_check_data(Request $request)
    {
        $query = DB::table('vw_app_list_trans_qc_check');
        
         
        $query->whereBetween('trans_date', [$request->input('startDate'), $request->input('endDate')]);

        $data = $query->orderBy('trans_date')->get();

        return response()->json([
            'data' => $data
        ]);
    }  
    
    public function save_qc_check(Request $request)
    {
        DB::beginTransaction();
        try {
            // dd($request);
            $userId = Auth::id();
            $now = Carbon::now();
            $doc_num_generated = NumberGenerator::generateNumberV4('trans_purchase_invoice', 'QCCD-IQC');
          
            // Header Data
            $data = [
                'ppm' => ($request->qty_ng/$request->qty_check) * 1000000,
                'trans_po_id' => $request->trans_po_id,
                'trans_rr_detail_id' => $request->trans_rr_detail_id,
                'item_id' => $request->item_id,
                'checking_date' => $request->checking_date,
                'process_date' => $request->process_date,
                'doc_num' => $doc_num_generated['doc_num'],
                'doc_counter' => $doc_num_generated['doc_counter'],
                'flag_checking_type' => $request->flag_checking_type,
                'flag_shift' => $request->flag_shift,
                'flag_sampling_level' => $request->sampling == "on" ? 1 : 0,
                'flag_cavity' => $request->flag_cavity,
                'flag_claim_submit' => $request->flag_claim_submit,
                'flag_cavity_action' => $request->flag_cavity_action,
                'flag_judgement_sampling' => $request->flag_judgement_sampling == "on" ? 1 :0,
                'flag_judgement_sorting' => $request->flag_judgement_sorting == "on" ? 1: 0,
                'flag_judgement_rework' => $request->flag_judgement_rework == "on" ? 1 : 0,
                'flag_judgement_return' => $request->flag_judgement_return == "on" ? 1 : 0,
                'qty_check' => $request->qty_check,
                'qty_receiving' => $request->qty_receiving,
                'qty_ng' => $request->qty_ng,
                'qty_rework' => $request->qty_rework,
                'generated_id' => Str::uuid()->toString(),
                'flag_active' => 1,
                'created_by' => $userId,
                'created_at' => $now,
                'remarks' => $request->remarks,
            ];
    
            // Simpan data Header
            $qualityControl = QualityControlCheck::create($data);
          
            $detail = [
                'trans_qc_id' => $qualityControl->id,
                'weld_line' => $request->weld_line,
                'silver' => $request->silver,
                'crack' => $request->crack,
                'sort_mould' => $request->sort_mould,

                'corrosive' => $request->corrosive,
                'flow_mark' => $request->flow_mark,
                'sink_mark' => $request->sink_mark,
                'black_dot' => $request->black_dot,

                'flashes' => $request->flashes,
                'oily' => $request->oily,
                'white_mark' => $request->white_mark,
                'fleck' => $request->fleck,

                'gas_mark' => $request->gask_mark,
                'broken_runner' => $request->broken_runner,
                'shortage' => $request->shortage,
                'non_standard_packing' => $request->non_standard_packing,

                'step' => $request->step,
                'excess_material' => $request->excess_material,
                'dented_scrath_wip' => $request->dented_scrath_wip,
                'dirty_wip' => $request->dirty_wip,

                'mix_part_wip' => $request->mix_part_wip,
                'over_cut_wip' => $request->over_cut_wip,
                'bending_wip' => $request->bending_wip,
                'dirty_wip' => $request->dirty_wip,
                'dimention_wip' => $request->dimention_wip,
                'gate_cut_wip' => $request->gate_cut_wip,

                'dented_scrath_process' => $request->dented_scrath_process,
                'dirty_process' => $request->dirty_process,
                'mix_part_process' => $request->mix_part_process,
                'over_cut_process' => $request->over_cut_process,
                
                'bending_process' => $request->bending_process,
                'dimention_process' => $request->dimention_process,
                'broken' => $request->broken,
                'wrinkle' => $request->wrinkle,
                'gate_cut_process' => $request->gate_cut_process,
                
                'white_wash' => $request->white_wash,
                'peel_off' => $request->peel_off,
                'burn_mark' => $request->burn_mark,
                'yellowish' => $request->yellowish,
                
                'under_shinning' => $request->under_shinning,
                'skip' => $request->skip,
                'bubble' => $request->bubble,
                'rough_dot' => $request->rough_dot,
                
                'copper_mark' => $request->copper_mark,
                'over_shinning' => $request->over_shinning,
                'burn_chrome' => $request->burn_chrome,
                'dot' => $request->dot,
                'pitting' => $request->pitting,
                
                'not_in_a_position' => $request->not_in_a_position,
                'damage' => $request->damage,
                'fold' => $request->fold,
                'over_tape' => $request->over_tape,
                
                'under_tape' => $request->under_tape,
                'dirty_spray' => $request->dirty_spray,
                'over_spray' => $request->over_spray,
                'under_spray' => $request->under_spray,
                
                'uneven_spray' => $request->uneven_spray,
                'glass' => $request->glass,
                'polish_mark' => $request->polish_mark,
                'orange_peel' => $request->orange_peel,

                'other' => $request->other,

                ];
    
            QualityControlCheckDetail::insert($detail);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return redirect("/qc");
    }   
    
}