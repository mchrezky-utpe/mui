<?php
namespace App\Exports;

use App\Models\VwPricelist;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PricelistExport implements FromCollection, WithHeadings, ShouldAutoSize
{
   public function collection()
    {
        return VwPricelist::select(
            'person_supplier',   
            'sku_id',
            'sku_name',
            'gen_currency_id',
            'sku_procurement_unit',
            'currency',
            'price',  
            'price_retail',  
            'pricelist_status',
            'valid_date_from',
            'valid_date_to',
            'valid_date_status',
        )->get();
    }

    public function headings(): array
    {
        return [
            'Supplier',
            'Item Code',
            'Item Name',
            'Item Type',
            'Procurement Unit',
            'Currency',
            'Price',
            'Retail Price',
            'Status',
            'Valid From',
            'Valid Until',
            'Valid Status',
        ];
    }
}
