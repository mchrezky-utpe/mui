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
