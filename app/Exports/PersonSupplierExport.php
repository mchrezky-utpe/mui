<?php

namespace App\Exports;

use App\Models\VwExportMasterPersonSupplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonSupplierExport implements FromCollection,WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return VwExportMasterPersonSupplier::select(
            'manual_id',               // Supplier Code
            'description',             // Supplier Name
            'prefix',                  // Initials
            'main_address',              // Address
            'main_phone',                // Phone
            'main_fax',                  // Fax
            'contact_person',       // Con. Person Name
            'contact_person_phone',                // Con. Person Phone
            'main_email',                // Email
            'wh_del_pic_name',       // WH/Del PIC Name
            'wh_del_pic_email',                // WH/Del PIC Email
            'qc_pic_name',       // QC PIC Name
            'qc_pic_email',
            'created_at',                 // QC PIC Email
        )->get();
    }

    public function headings(): array
    {
        return [
            'Supplier Code',
            'Supplier Name',
            'Initials',
            'Address',
            'Phone',
            'Fax',
            'Con. Person Name',
            'Con. Person Phone',
            'Email',
            'WH/Del PIC Name',
            'WH/Del PIC Email',
            'QC PIC Name',
            'QC PIC Email',
            'Created At',
        ];
    }
}
