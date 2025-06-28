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
            'material_code', //material code
            'material_description', //material description
            'spesification_code', //specification code
            'spesification_description', //specification descr
            'sales_category', //sales category
            'item_sub_category', //item sub category
            'item_type', //item type
            'porcurement_type',    //procurement type
            'inventory_unit',    //inventory unit
            'procurement_unit',   //procurement unit
            'con_value',   //conversion'
            'inv_reg',  //inventory register
        )->get();
    }

    public function headings(): array
    {
        return [
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
        ];
    }
}
