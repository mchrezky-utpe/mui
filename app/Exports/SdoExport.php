<?php
namespace App\Exports;

use App\Models\Transaction\VwSdoItemList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SdoExport implements FromCollection, WithHeadings, ShouldAutoSize
{
   public function collection()
    {
        return VwSdoItemList::select(
            'do_doc_num',
            'trans_date',
            'department',
            'supplier',
            'po_doc_num',
            'sds_doc_num',
            'description',
            'sku_description',
            'sku_prefix',
            'sku_specification_code',
            'sku_type',
            'qty',
            'qty_outstanding',
        )->get();
    }

    public function headings(): array
    {
        return [
            'DO Number',
            'DO Date',
            'Department',
            'Supplier',
            'PO Number',
            'SDS Number',
            'Description',
            'Item Name',
            'item Code',
            'Spec Code',
            'Item Type',
            'Qty',
            'OS Qty'
        ];
    }
}