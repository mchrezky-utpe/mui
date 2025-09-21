<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;
use Maatwebsite\Excel\Facades\Excel;

class VwExportMasterPersonSupplier extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'vw_app_export_mst_person_supplier';

    public $timestamps = false;

    use HasUserTracking;

    public function export_person_supplier()
    {
        return Excel::download(new \App\Exports\PersonSupplierExport, 'person_supplier.xlsx');
    }
}
