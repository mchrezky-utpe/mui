<?php
namespace App\Exports;

use App\Models\VwPurchaseRequisitionDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseRequisitionDetailExport implements FromCollection, WithHeadings, ShouldAutoSize
{
   public function collection()
    {
        return VwPurchaseRequisitionDetail::select(
            'doc_num',   
            'trans_date',
            'req_date',
            'department',
            'transaction_type',
            'status_type_item',
            'item_status',
            'flag_status',
            'doc_num_po',
            'sku_id',
            'sku_name',
            'spec_code',
            'item_type',
            'sku_unit',
            'val_price',
            'qty',
            'val_total',
            'description',
        )->get();
    }

    public function headings(): array
    {
        return [
            'PR Number',
            'Date',
            'Require Date',
            'Department',
            'Pr Type',
            'PI Type',
            'Approval',
            'Process',
            'PO Number',
            'Item Code',
            'Item Name',
            'Spec Code',
            'Item Type',
            'Item Unit',
            'Price',
            'Qty',
            'Amount',
            'Remark',
        ];
    }
}
