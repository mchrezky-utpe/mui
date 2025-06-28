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
            'part_code',    //Part Code
            'part_name',  //Part Name
            'Specification_Code', //Specification code
            'Specification_Description', //Specification Description
            'Sales_category',   //Sales category
            'set_code',    //Set Code
            'Item_Sub_Category',    //Item Sub Category
            'Item_type',    //Item type
            'business_type', //model
            'model', //surace area
            'surace_area',   //weight
            'weight',    //inventory unit
            'inventory_unit',    //procurement type
            'procurement_type',   //procurement unit
            'procurement_unit',   //conversion'
            'conversion',  //inventory register
            'inventory_register',  //inventory register
        )->get();
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
