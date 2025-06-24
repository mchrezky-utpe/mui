<?php

namespace App\Exports;

use App\Models\MasterPersonSupplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonSupplierExport implements FromCollection,WithHeadings
{
    public function collection()
    {
        return MasterPersonSupplier::select(
            'manual_id',               // Supplier Code
            'description',             // Supplier Name
            'prefix',                  // Initials
            'address_01',              // Address
            'phone_01',                // Phone
            'fax_01',                  // Fax
            'contact_person_01',       // Con. Person Name
            'phone_02',                // Con. Person Phone
            'email_01',                // Email
            'contact_person_02',       // WH/Del PIC Name
            'email_02',                // WH/Del PIC Email
            'contact_person_03',       // QC PIC Name
            'email_03'                 // QC PIC Email
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
        ];
    }
}
