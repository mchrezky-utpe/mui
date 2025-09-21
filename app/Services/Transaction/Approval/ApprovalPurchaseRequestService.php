<?php

namespace App\Services\Transaction\Approval;

use App\Models\Transaction\Approval\ApprovalPurchaseRequestVw;
use App\Models\Transaction\Approval\ApprovalPurchaseRequestVwDt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalPurchaseRequestService
{
    public function list(){
          return ApprovalPurchaseRequestVw::orderBy('created_at', 'DESC')->get();
    }

    public function list_pagination(Request $request){
        $start = $request->input('start'); 
        $length = $request->input('length');
        $search = $request->input('search.value'); 
        $query = DB::table('vw_app_list_log_pr_approval_hd');

        if ($request->start_date != null && $request->end_date != null) {
            $query->whereBetween('trans_date', [$request->start_date, $request->end_date]);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->Where('doc_num', 'like', '%' . $search . '%')
                    ->orWhere('supplier', 'like', '%' . $search . '%');
            });
        }

        $recordsTotal = $query->count();

        $recordsFiltered = $query->count();

        if ($length > 0){        
            $data = $query->limit($length)->offset($start)->get();
        }
        else{
            $data = $query->get();
        }

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' =>  $recordsFiltered
        ];
    }

    public function approve(Request $request)
    {
        $user = $request->session()->get('user');
        //$userId = $user['id'];
        $userId = 'jeruk';
        $selected_ids = explode(",", $request->input('selected_ids'));

        DB::beginTransaction();
        try {
            if ($request->input('selected_ids')) {
                foreach ($selected_ids as $pr_id) {
                    DB::statement('CALL sp_log_pr_approval_update_hd(?, ?, ?, ?)', [$pr_id, 2, 'OK', $userId]);
                    DB::statement('CALL sp_log_pr_approval_update_dt_all(?, ?)', [$pr_id, 1]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function deny(Request $request)
    {
        $user = $request->session()->get('user');
        $userId = $user['id'];
        $selected_ids = explode(",", $request->input('selected_ids'));

        DB::beginTransaction();
        try {
            if ($request->input('selected_ids')) {
                foreach ($selected_ids as $pr_id) {
                    DB::statement('CALL sp_log_pr_approval_update_hd(?, ?, ?, ?)', [$pr_id, 3, 'NOT OK', $userId]);
                    DB::statement('CALL sp_log_pr_approval_update_dt_all(?, ?)', [$pr_id, 2]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function hold(Request $request)
    {
        $user = $request->session()->get('user');
        $userId = $user['id'];
        $selected_ids = explode(",", $request->input('selected_ids'));

        DB::beginTransaction();
        try {
            if ($request->input('selected_ids')) {
                foreach ($selected_ids as $pr_id) {
                    DB::statement('CALL sp_log_pr_approval_update_hd(?, ?, ?, ?)', [$pr_id, 4, 'SUSPEND', $userId]);
                    DB::statement('CALL sp_log_pr_approval_update_dt_all(?, ?)', [$pr_id, 3]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function getItem($id){
        return ApprovalPurchaseRequestVwDt::where('trans_pr_id', $id)->get();
    }

    public function deny_item(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->input('id');
            if ($id) {
                DB::statement('CALL sp_log_pr_approval_update_dt_single(?, ?)', [$id, 2]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function hold_item(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->input('id');
            if ($id) {
                DB::statement('CALL sp_log_pr_approval_update_dt_single(?, ?)', [$id, 3]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

}
