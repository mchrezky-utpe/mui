<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSku extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'mst_sku';

    public function detail()
    {
        return $this->hasOne(MasterSkuDetail::class, 'id','sku_detail_id');
    }

    public function model()
    {
        return $this->hasOne(MasterSkuModel::class, 'id','sku_model_id');
    }

    public function packaging()
    {
        return $this->hasOne(MasterSkuPackaging::class, 'id','sku_packaging_id');
    }

    public function process()
    {
        return $this->hasOne(MasterSkuProcess::class, 'id','sku_process_id');
    }

    public function type()
    {
        return $this->hasOne(MasterSkuType::class, 'id','sku_type_id');
    }

    public function unit()
    {
        return $this->hasOne(MasterSkuUnit::class, 'id','sku_unit_id');
    }

    public function business()
    {
        return $this->hasOne(MasterSkuBusiness::class, 'id','sku_business_type_id');
    }
}
