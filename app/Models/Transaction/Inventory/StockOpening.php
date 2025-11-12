<?php

namespace App\Models\Transaction\Inventory;

use Illuminate\Database\Eloquent\Model;

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


}
