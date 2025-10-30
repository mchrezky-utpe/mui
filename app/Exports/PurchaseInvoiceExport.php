<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray; // Ganti dari FromCollection ke FromArray
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PurchaseInvoiceExport implements FromArray, WithHeadings, WithStyles, WithEvents, WithTitle
{
    protected $invoices;

    public function __construct($invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        $data = [];
        
        foreach ($this->invoices as $invoice) {
            // Header invoice - hanya data yang diperlukan
            $data[] = [
                $invoice['invoice_date'] ?? '',
                $invoice['invoice_code'] ?? '',
                $invoice['invoice_number'] ?? '',
                $invoice['department'] ?? '',
                $invoice['supplier'] ?? '',
                $invoice['invoice_type'] ?? '',
                $invoice['invoice_phase'] ?? '',
                $invoice['top'] ?? '',
                $invoice['approval_required'] ?? '',
                $invoice['currency'] ?? '',
                $invoice['sub_total'] ?? 0,
                $invoice['discount'] ?? 0,
                $invoice['ppn'] ?? 0,
                $invoice['pph'] ?? 0,
                $invoice['total'] ?? 0,
                $invoice['phase1_receipt_date'] ?? '',
                $invoice['phase1_recipient'] ?? '',
                $invoice['phase1_receipt_status'] ?? '',
                $invoice['phase2_receipt_date'] ?? '',
                $invoice['phase2_recipient'] ?? '',
                $invoice['phase2_receipt_status'] ?? '',
                $invoice['phase3_receipt_date'] ?? '',
                $invoice['phase3_recipient'] ?? '',
                $invoice['phase3_receipt_status'] ?? '',
                $invoice['approval_date'] ?? '',
                $invoice['approval_status'] ?? ''
            ];

            // Header items
            $data[] = [
                'Date',
                'PO Number',
                'DO Number',
                'Item Code',
                'Item Name',
                'Item Type',
                'Unit',
                'Quantity',
                'Curr',
                'Price',
                'Amount',
                'Check',
                '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''
            ];

            // Items data - gunakan chunk jika banyak data
            $items = $invoice['items'] ?? [];
            foreach ($items as $item) {
                $data[] = [
                    $item['date'] ?? '',
                    $item['po_number'] ?? '',
                    $item['do_number'] ?? '',
                    $item['item_code'] ?? '',
                    $item['item_name'] ?? '',
                    $item['item_type'] ?? '',
                    $item['unit'] ?? '',
                    $item['quantity'] ?? 0,
                    $item['currency'] ?? '',
                    $item['price'] ?? 0,
                    $item['amount'] ?? 0,
                    ($item['checked'] ?? false) ? 'True' : 'False',
                    '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''
                ];
                
                // Bebaskan memory setiap 100 rows
                if (count($data) % 100 === 0) {
                    gc_collect_cycles();
                }
            }

            // Empty row setelah items
            $data[] = [
                'MERGE_ROW', '', '', '', '', '', '', '', '', '', 
                '', '', '', '', '', '', '', '', '', '',
                '', '', '', '', '', '', '', '', '', '', ''
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            // Baris 1 - Header utama
            [
                'Invoice Information (Phase 0)', '', '', '', '',
                'Invoice Additional Information', '', '', '',
                'Amount', '', '', '', '', '',
                'Phase 1', '', '',
                'Phase 2', '', '',
                'Phase 3', '', '',
                'Purchase Invoice Approval', ''
            ],
            // Baris 2 - Sub header
            [
                'Invoice Date', 'Invoice Code', 'Invoice Number', 'Department', 'Supplier',
                'Invoice Type', 'Invoice Phase', 'TOP', 'Appr. Req.', 'Curr.',
                'Sub Total', 'Discount', 'PPN', 'PPH', 'Total',
                'Receipt Date', 'Recipient', 'Receipt Status',
                'Receipt Date', 'Recipient', 'Receipt Status',
                'Receipt Date', 'Recipient', 'Receipt Status',
                'Approval Date', 'Approval Status'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Hanya define styles dasar, sisanya di AfterSheet
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 11],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E6E6FA']]
            ],
            2 => [
                'font' => ['bold' => true, 'size' => 9],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0F0F0']]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Merge cells untuk header utama Baris 1
                $merges = [
                    'A1:E1', 'F1:I1', 'J1:O1', 'P1:R1', 'S1:U1', 'V1:X1', 'Y1:Z1'
                ];
                
                foreach ($merges as $merge) {
                    $event->sheet->mergeCells($merge);
                    $sheet->getStyle($merge)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                // AUTO WIDTH UNTUK SEMUA KOLOM
                foreach (range('A', $highestColumn) as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                 // Handle empty rows (MERGE_ROW)
            for ($row = 1; $row <= $highestRow; $row++) {
                $cellValue = $sheet->getCell('A' . $row)->getValue();
                if ($cellValue === 'MERGE_ROW') {
                    // Clear nilai MERGE_ROW
                    $sheet->setCellValue('A' . $row, '');
                    
                    // Merge seluruh row dari A sampai AD
                    $event->sheet->mergeCells('A' . $row . ':Z' . $row);
                    
                    // Kasih warna background
                    $sheet->getStyle('A' . $row . ':Z' . $row)
                          ->getFill()
                          ->setFillType(Fill::FILL_SOLID)
                          ->getStartColor()
                          ->setRGB('F0F0F0'); // Abu-abu muda
                    
                    // Atau kasih height yang lebih kecil
                    $sheet->getRowDimension($row)->setRowHeight(15);
                }
            }

             // Cari dan style semua header items
            for ($row = 1; $row <= $highestRow; $row++) {
                $cellValue = $sheet->getCell('A' . $row)->getValue();
                
                // Jika cell A berisi 'Date' (header items)
                if ($cellValue === 'Date') {
                    // Style untuk header items (kolom A sampai L)
                    $sheet->getStyle('A' . $row . ':L' . $row)
                          ->applyFromArray([
                              'font' => ['bold' => true],
                              'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
                          ]);
                }
                
                // Deteksi empty rows untuk styling
                $isRowEmpty = true;
                foreach (['A', 'B', 'C', 'D'] as $col) {
                    if (!empty($sheet->getCell($col . $row)->getValue())) {
                        $isRowEmpty = false;
                        break;
                    }
                }
              
            }

                // Set column widths
                $widths = [
                    'A' => 12, 'B' => 15, 'C' => 18, 'D' => 10, 'E' => 25,
                    'F' => 12, 'G' => 12, 'H' => 25, 'I' => 8, 'J' => 6,
                    'K' => 10, 'L' => 12, 'M' => 25, 'N' => 8, 'O' => 10,
                    'P' => 8, 'Q' => 6, 'R' => 6, 'S' => 10, 'T' => 12,
                    'U' => 12, 'V' => 12, 'W' => 12, 'X' => 12, 'Y' => 12,
                    'Z' => 12, 'AA' => 12, 'AB' => 12, 'AC' => 12, 'AD' => 12
                ];

                foreach ($widths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Add borders hanya untuk area yang digunakan
                if ($highestRow > 0) {
                    $styleArray = [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ];
                    $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray($styleArray);
                }

                // Bebaskan memory
                gc_collect_cycles();
            },
        ];
    }

    public function title(): string
    {
        return 'purchase_invoice_list';
    }
}