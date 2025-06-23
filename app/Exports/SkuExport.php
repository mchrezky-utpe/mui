<?php
namespace App\Exports;

use App\Models\Master\Sku\SkuListVw;
use App\Models\MasterSku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SkuExport implements FromCollection, WithHeadings
{
   public function collection()
    {
        return SkuListVw::select(
            'sku_id',
            'sku_name',
            'sku_material_type',
            'sku_business_type',
            'sku_sales_category'
        )->where('flag_sku_type', 1)->get();
    }

    public function headings(): array
    {
        return [
            'SKU ID',
            'Item Name',
            'Material Type',
            'Business Type',
            'Sales Category',
        ];
    }
}
