<?php

namespace App\Exports;

use App\Models\Master\Sku\SkuListVw as SkuSkuListVw;
use App\Models\SkuListVw;
use Maatwebsite\Excel\Concerns\FromCollection;

class SkuGeneralItemExport implements FromCollection
{
    public function collection()
    {
        return SkuSkuListVw::where('flag_sku_type', 3)
            ->select([
                'sku_id',
                'sku_name',
                'sku_material_type',
                'sku_business_type',
                'sku_sales_category'
            ])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Item Code',
            'Item Name',
            'Item Type',
            'Business Type',
            'Sales Category'
        ];
    }
}
