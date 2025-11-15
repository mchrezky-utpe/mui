<?php

namespace App\Models\Transaction\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockOpening extends Model
{
    protected $table = 'mst_sku'; // ganti dengan nama tabel kamu di database
    protected $primaryKey = 'id';
    public $timestamps = true; // ubah ke true kalau tabel punya created_at & updated_at

    protected $fillable = [
        'manual_id',
        'description',
        'specification_code',
        'flag_sku_type',
        // tambahkan kolom lain sesuai kebutuhan
    ];

    public function scopeListPartInformation($query, $search = null)
    {
        $query->where('flag_sku_type', 2)
            ->select('manual_id', 'description', 'specification_code')
            ->orderBy('description', 'asc');

        if (!empty($search)) {
            $query->where(function ($sub) use ($search) {
                $sub->where('manual_id', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('specification_code', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function scopeReturnablePackagingView($query)
    { 
        return DB::table('mst_sku as s')
        ->join('mst_sku_type as t', 's.sku_type_id', '=', 't.id')
        ->join('mst_sku_sub_category as sc', 't.sku_sub_category_id', '=', 'sc.id')
        ->leftJoin('mst_sku_model as m', 's.sku_model_id', '=', 'm.id')
        ->leftJoin('mst_sku_unit as u', 's.sku_unit_id', '=', 'u.id')
        ->select([
            's.manual_id as pcc_code',
            'sc.description as sub_category',
            't.description as category_type',
            'sc.description as category_name',
            'm.description as model',
            'u.description as unit',
        ])
        ->where(function($q) {
            $q->where('sc.description', 'like', '%RETURNABLE%')
              ->orWhere('sc.description', 'like', '%NON RETURNABLE%');
        })
        ->groupBy(
            's.manual_id',
            'sc.description',
            't.description',
            'm.description',
            'u.description'
        );
    }




}
