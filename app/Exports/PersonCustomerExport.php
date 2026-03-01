<?php

namespace App\Exports;

use App\Models\MasterPersonCustomer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonCustomerExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return MasterPersonCustomer::select(
            'prefix',
            'name',
            'initials',
            'office_address',
            'phone_number',
            'fax_number',
            'email',
            'npwp',
            'contact_person_name',
            'contact_person_phone',
            'contact_person_email',
        )->get();
    }

    public function headings(): array
    {
        return [
            'Customer Code',
            'Customer Name',
            'Initials',
            'Office Address',
            'Phone',
            'Fax',
            'Email',
            'NPWP',
            'Contact Person Name',
            'Contact Person Phone',
            'Contact Person Email',
        ];
    }
}
