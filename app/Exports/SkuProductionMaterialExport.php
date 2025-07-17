<?php

namespace App\Exports;

use App\Models\VwMasterSkuProductionMaterial;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SkuProductionMaterialExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return VwMasterSkuProductionMaterial::select(
            'blob_image',
            'sku_id', //material code
            'sku_name', //material description
            'sku_specification_code', //specification code
            'sku_specification_detail', //specification descr
            'sku_sales_category', //sales category
            'sku_sub_category', //item sub category
            'sku_material_type', //item type
            'sku_procurement_type',    //procurement type
            'sku_inventory_unit',    //inventory unit
            'sku_procurement_unit',   //procurement unit
            'val_conversion',   //conversion'
            'is_inventory_register',  //inventory register
            'created_at',
        )->get();
    }

    public function headings(): array
    {
        return [
            'Image',
            'Material Code',
            'Material Description',
            'Specification Code',
            'Specification Description',
            'Sales Category',
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
