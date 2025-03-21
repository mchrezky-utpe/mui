<?php

namespace App\Models\Master\Sku;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;


/**
 * @OA\Schema(
 *     schema="SkuUnit",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="prefix",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="manual_id",
 *         type="string"
 *     )
 * )
 */
class SkuUnitListVw extends Model
{
    protected $table = 'vw_app_list_mst_sku_unit';
    public $timestamps = false;
    protected $guarded = [];  
}
