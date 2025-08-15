<?php

namespace App\Models\Master\Bom;

use App\Exports\BomExport;
use App\Models\MasterSku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;
use Maatwebsite\Excel\Facades\Excel;

class Bom extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'mst_sku_bom';

    use HasUserTracking;

      public function export_bom()
    {
        $data = Bom::with(['details'])->get();
return Excel::download(new BomExport($data), 'bom_grouped.xlsx');
    }
public function details()
{
    return $this->hasMany(BomDetail::class, 'sku_bom_id');
}

public function sku()
{
    return $this->belongsTo(MasterSku::class, 'sku_id');
}




//     public function sku()
// {
//     return $this->belongsTo(\App\Models\MasterSku::class, 'sku_id');
// }

// public function details()
// {
//     return $this->hasMany(\App\Models\Master\Bom\BomDetail::class, 'sku_bom_id');
// }
}
