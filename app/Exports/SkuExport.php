<?php
namespace App\Exports;

use App\Models\VwMasterSkuPartInformation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SkuExport implements FromCollection, WithHeadings, ShouldAutoSize
{
   public function collection()
    {
        return VwMasterSkuPartInformation::select(
            'blob_image',
            'sku_id',    //Part Code
            'sku_name',  //Part Name
            'sku_specification_code', //Specification code
            'sku_specification_detail', //Specification Description
            'sku_sales_category',   //Sales category
            'group_tag',    //Set Code
            'sku_material_type',    //Item Sub Category
            'sku_sub_category',    //Item type
            'sku_business_type', //model
            'sku_model', //surace area
            'val_area',   //weight
            'val_weight',    //inventory unit
            'sku_inventory_unit',    //procurement type
            'sku_procurement_type',   //procurement unit
            'sku_procurement_unit',   //conversion'
            'val_conversion',  //inventory register
            'is_inventory_register',  //inventory register
            'created_at',
        )->get();
    }

    public function headings(): array
    {
        return [
            'Image',
            'Part Code',
            'Part Name',
            'Specification Code',
            'Specification Description',
            'Sales Category',
            'Set Code',
            'Item Sub Category',
            'Item Type',
            'Business Type',
            'Model',
            'Surace Area',
            'Weight',
            'Inventory Unit',
            'Procurement Type',
            'Procurement Unit',
            'Conversion Value',
            'Inventory Register',
            'Created At',
        ];
    }
}
