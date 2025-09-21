<?php
namespace App\Exports;

use App\Models\VwPurchaseOrderDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseOrderDetailExport implements FromCollection, WithHeadings, ShouldAutoSize
{
   public function collection()
    {
        return VwPurchaseOrderDetail::select(
            'trans_date',
            'doc_num',   
            'sku_prefix',
            'sku_name',
            'sku_specification_code',
            'sku_material_type',
            'trans_pr_date',
            'doc_pr_num',
            'department',
            'transaction_type',
            'supplier',
            'price_d',
            'qty',
            'subtotal_d',
            'description',
        )->get();
    }

    public function headings(): array
    {
        return [
            'PO Date',
            'PO Number',
            'Item Code',
            'Item Name',
            'Spec Code',
            'Item Type',
            'PR Date',
            'PR Number',
            'Departmen',
            'PO Type',
            'Supplier',
            'Price',
            'Qty',
            'Amount',
            'Remark',
        ];
    }
}
