<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class MasterCustomerDeliveryDestination extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'mst_customer_delivery_destination';

    public $timestamps = false;

    use HasUserTracking;
}
