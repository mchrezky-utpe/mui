<?php
namespace App\Exports;

use App\Models\VwPurchaseRequisition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseRequisitionExport implements FromCollection, WithHeadings, ShouldAutoSize
{
   public function collection()
    {
        return VwPurchaseRequisition::select(
            'doc_num',   
            'trans_date',
            'transaction_type',
            'transaction_purpose',
            'supplier',
            'transaction_status',
            'description',
        )->get();
    }

    public function headings(): array
    {
        return [
            'PR Number',
            'Date',
            'Type',
            'Purpose',
            'Supplier',
            'Status',
            'Remark',
        ];
    }
}
