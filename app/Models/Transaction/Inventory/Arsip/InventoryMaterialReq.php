<?php

namespace App\Models\Transaction\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class InventoryMaterialReq extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'invetory_material_req';

    use HasUserTracking;
}
