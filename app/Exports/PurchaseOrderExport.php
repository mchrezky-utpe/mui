<?php
namespace App\Exports;

use App\Models\VwPurchaseOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseOrderExport implements FromCollection, WithHeadings, ShouldAutoSize
{
   public function collection()
    {
        return VwPurchaseOrder::select(
            'doc_num',   
            'trans_date',
            'po_type',
            'supplier',
            'description',
            'pr_doc_num',
            'po_status',
            'date_exist_pdf',
            'date_edi',
            'rev_counter',
            'terms',
            'currency',
            'val_sub_total',
            'val_vat',
            'val_pph23',
            'val_discount',
            'val_total',
        )->get();
    }

    public function headings(): array
    {
        return [
            'PO Number',
            'Date',
            'Type',
            'Supplier',
            'Remark',
            'PR Number',
            'PO',
            'PDF',
            'EDI',
            'Revision',
            'Terms',
            'Currency',
            'Sub Total',
            'PPN',
            'PPH23',
            'Discount',
            'Total',
        ];
    }
}
