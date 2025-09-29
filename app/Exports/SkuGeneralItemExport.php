<?php

namespace App\Exports;

use App\Models\VwMasterSkuGeneralItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SkuGeneralItemExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return VwMasterSkuGeneralItem::select(
            'blob_image',
            'sku_id', //item code
            'sku_name',
            'sku_specification_code', //specification code
            'sku_specification_detail', //specification descr
            'sku_sales_category', //item sub category
            'sku_material_type', //item type
            'sku_procurement_type',    //procurement type
            'sku_inventory_unit',    //inventory unit
            'sku_procurement_unit',   //procurement unit
            'val_conversion',   //conversion'
            'is_inventory_register',  //inventory register
            'created_at',
        )->where('flag_sku_type', 3)->get();
    }

    public function headings(): array
    {
        return [
            'Image',
            'Item Code',
            'Item Name',
            'Spesification Code',
            'Spesification Description',
            'Item Sub Category',
            'Item Type',
            'Procurement Type',
            'Inventory Unit',
            'Procurement Unit',
            'Con. Value',
            'Inv. Reg',
            'Created At',

        ];
    }
}
