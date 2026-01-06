<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;
use App\Models\Master\Sku\MasterSkuType;
use Maatwebsite\Excel\Facades\Excel;

class MasterSku extends Model
{
    use HasFactory;
    use HasUserTracking;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'mst_sku';

    public function scopePartInformatoin($q)
    {
        return $q->where('flag_sku_type', 1);
    }

    // Production Material
    public function scopeProductionMaterials($q)
    {
        return $q->where('flag_sku_type', 2);
    }

    // General Item
    public function scopeGeneralItems($q)
    {
        return $q->where('flag_sku_type', 3);
    }

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

    public function export()
    {
        return Excel::download(new \App\Exports\SkuExport, 'sku.xlsx');
    }

    public function export_production_material()
    {
        return Excel::download(new \App\Exports\SkuProductionMaterialExport, 'sku_production_material.xlsx');
    }
    
    public function export_general_item()
    {
        return Excel::download(new \App\Exports\SkuGeneralItemExport, 'sku_general_item.xlsx');
    }

    
}
