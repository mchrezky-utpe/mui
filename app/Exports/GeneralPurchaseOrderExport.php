<?php
namespace App\Exports;

use App\Models\VwGeneralPurchaseOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GeneralPurchaseOrderExport implements FromCollection, WithHeadings, ShouldAutoSize
{
   public function collection()
    {
        return VwGeneralPurchaseOrder::select(
            'do_date',
            'do_doc_num',
            'po_doc_num',
            'sku_prefix',
            'sku_description',
            'sku_specification_code',
            'sku_type',
            'sku_inventory_unit',
            'qty',
            'qty',
        )->get();
    }

    public function headings(): array
    {
        return [
            'Receiving Date',
            'DO Number',
            'PO Number',
            'Item Code',
            'Item Name',
            'Specification Code',
            'Item Type',
            'Unit',
            'Qty Order',
            'Outstanding',
        ];
    }
}
