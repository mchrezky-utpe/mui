<?php
namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PurchaseInvoiceExport implements FromCollection, WithHeadings, ShouldAutoSize,WithStyles,WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            // Baris 1 - Header utama dengan colspan
            [
                'No', 
                'Project Name', 
                'Fase 1', '', '', 
                'Fase 2', '', '', 
                'Fase 3', '', '',
                'Overall Status'
            ],
            // Baris 2 - Sub header
            [
                'No',
                'Project Name',
                'Receipt Date', 'Recipient Status', 'Completion %',
                'Receipt Date', 'Recipient Status', 'Completion %', 
                'Receipt Date', 'Recipient Status', 'Completion %',
                'Overall Status'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header baris 1
            1 => [
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => 'center']
            ],
            // Style untuk sub header baris 2
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center']
            ],
            // Style untuk data
            'A3:L100' => [
                'alignment' => ['vertical' => 'top']
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge cells untuk header Fase
                $event->sheet->mergeCells('C1:E1'); // Fase 1
                $event->sheet->mergeCells('F1:H1'); // Fase 2
                $event->sheet->mergeCells('I1:K1'); // Fase 3

                // Set alignment untuk header yang di-merge
                $sheet->getStyle('C1:E1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('F1:H1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('I1:K1')->getAlignment()->setHorizontal('center');

                // Auto size columns
                foreach(range('A', 'L') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Add borders
                $lastRow = count($this->data) + 2;
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ];
                $sheet->getStyle('A1:L' . $lastRow)->applyFromArray($styleArray);
            },
        ];
    }
}
