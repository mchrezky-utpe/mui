<?php

namespace App\Exports;

use App\Models\Master\Sku\SkuListVw;
use App\Models\MasterSku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SkuProductionMaterialExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return MasterSku::select(
            'manual_id', //material code
            'description', //material description
            'specification_code', //specification code
            'specification_detail', //specification descr
            'sku_business_type_id', //sales category
            'sku_type_id', //item sub category
            'sku_type_id', //item type
            'flag_sku_procurement_type',    //procurement type
            'sku_inventory_unit_id',    //inventory unit
            'sku_procurement_unit_id',   //procurement unit
            'val_conversion',   //conversion'
            'flag_inventory_register',  //inventory register
        )->where('flag_sku_type', 2)->get();
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
            'Con. Value',
            'Inv. Reg',
        ];
    }
}
