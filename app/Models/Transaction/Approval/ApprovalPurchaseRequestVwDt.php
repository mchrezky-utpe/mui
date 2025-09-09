<?php

namespace App\Models\Transaction\Approval;

use Illuminate\Database\Eloquent\Model;

class ApprovalPurchaseRequestVwDt extends Model
{
    protected $table = 'vw_app_list_log_pr_approval_dt';
    public $timestamps = false;
    protected $guarded = [];  
}
