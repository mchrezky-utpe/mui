<?php

namespace App\Exports;

use App\Models\Master\Sku\SkuListVw;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SkuProductionMaterialExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return SkuListVw::where('flag_sku_type', 2)
            ->select('sku_id', 'sku_name', 'sku_material_type', 'sku_business_type', 'sku_sales_category')
            ->get();
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

