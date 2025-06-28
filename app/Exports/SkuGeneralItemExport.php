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
            'item_code', //item code
            'item_name',
            'specification_code', //specification code
            'specification_description', //specification descr
            'item_sub_category', //item sub category
            'item_type', //item type
            'procurement_type',    //procurement type
            'inventory_unit',    //inventory unit
            'procurement_unit',   //procurement unit
            'con_value',   //conversion'
            'inv_reg',  //inventory register
        )->get();
    }

    public function headings(): array
    {
        return [
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
            'Inv. Reg'
        ];
    }
}
