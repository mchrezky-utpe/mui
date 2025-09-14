<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderRequestVwHd extends Model
{
    use HasFactory;
  
    protected $table = 'vw_app_list_trans_pr_hd';
    
    public function items()
    {
        return $this->hasMany(PurchaseOrderRequestVwDt::class, 'trans_pr_id','id');
    }

}
