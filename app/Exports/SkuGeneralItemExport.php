<?php

namespace App\Exports;

use App\Models\Master\Sku\SkuListVw as SkuSkuListVw;
use App\Models\MasterSku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SkuGeneralItemExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return MasterSku::select(
            'manual_id', //item code
            'description',
            'specification_code', //specification code
            'specification_detail', //specification descr
            'sku_type_id', //item sub category
            'sku_type_id', //item type
            'flag_sku_procurement_type',    //procurement type
            'sku_inventory_unit_id',    //inventory unit
            'sku_procurement_unit_id',   //procurement unit
            'val_conversion',   //conversion'
            'flag_inventory_register',  //inventory register
        )->where('flag_sku_type', 3)->get();
    }

    public function headings(): array
    {
        return [
            'Item Code',
            'Item Name',
            'Spesification Code',
            'Spesification Description',
            'Item Sun Category',
            'Item Type',
            'Procurement Type',
            'Inventory Unit',
            'Con. Value',
            'Inv. Reg'
        ];
    }
}
