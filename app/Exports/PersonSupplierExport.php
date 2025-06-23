<?php

namespace App\Exports;

use App\Models\MasterPersonSupplier;
use Maatwebsite\Excel\Concerns\FromCollection;

class PersonSupplierExport implements FromCollection
{
    public function collection()
    {
        return MasterPersonSupplier::select(
            'description',
            'contact_person_01',
            'phone_02',
            'contact_person_02',
            'email_02',
            'contact_person_03',
            'email_03'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Initial',
            'Con. Person Name',
            'Con. Person Phone',
            'WH/Del PIC Name',
            'WH/Del PIC Email',
            'QC PIC Name',
            'QC PIC Email',
        ];
    }
}
