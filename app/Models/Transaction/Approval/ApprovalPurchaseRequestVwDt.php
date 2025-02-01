<?php

namespace App\Models\Transaction\Approval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class ApprovalPurchaseRequestVwDt extends Model
{
    protected $table = 'vw_app_list_log_pr_approval_dt';
    public $timestamps = false;
    protected $guarded = [];  
}
