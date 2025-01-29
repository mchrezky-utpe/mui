<?php

namespace App\Models\Transaction\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class InventorySalesReturn extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'inventory_sales_return';

    use HasUserTracking;
}
