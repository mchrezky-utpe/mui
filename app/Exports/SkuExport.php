<?php
namespace App\Exports;

use App\Models\MasterSku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SkuExport implements FromCollection, WithHeadings, ShouldAutoSize
{
   public function collection()
    {
        return MasterSku::select(
            'manual_id',    //Part Code
            'description',  //Part Name
            'specification_code', //Specification code
            'specification_detail', //Specification Description
            'sku_business_type_id',   //Sales category
            'group_tag',    //Set Code
            'sku_type_id',    //Item Sub Category
            'sku_type_id',    //Item type
            'sku_model_id', //model
            'val_area', //surace area
            'val_weight',   //weight
            'sku_inventory_unit_id',    //inventory unit
            'flag_sku_procurement_type',    //procurement type
            'sku_procurement_unit_id',   //procurement unit
            'val_conversion',   //conversion'
            'flag_inventory_register',  //inventory register
        )->where('flag_sku_type', 1)->get();
    }

    public function headings(): array
    {
        return [
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
        ];
    }
}
