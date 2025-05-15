<?php

namespace App\Http\Controllers;

use App\Models\MasterPersonEmployee;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    
    public function exportEmployeePDF()
    {
        $data = MasterPersonEmployee::all();
    
        // Optional generate fullname jika belum otomatis di DB
        foreach ($data as $d) {
            $d->fullname = "{$d->firstname} {$d->middlename} {$d->lastname}";
        }
    
        $pdf = MasterPersonEmployee::loadView('pdf.template', compact('data'));
        return $pdf->download('data-employee.pdf');
    }
}