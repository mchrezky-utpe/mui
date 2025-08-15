<?php
namespace App\Exports;

use App\Models\Master\Bom\Bom;
use App\Models\Master\Bom\VwBomList;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

// class BomExport implements FromCollection,WithHeadings, ShouldAutoSize

// {
//     // public function collection()
//     // {
//     //     return VwBomList::select(
//     //         "BM-00114",
//     //         'sku_id',               // Part Code
//     //         'sku_name',             // Part name
//     //         'sku_model',            // Model
//     //         'remark',               // Remark
//     //         'verification',         // Verification
//     //         'status',               // Status
//     //         'main_priority'         // Main Priority
//     //     )->get();
//     // }
// //     public function collection()
// // {
// //     return VwBomList::select(
// //         'sku_id',               // Part Code
// //         'sku_name',             // Part Name
// //         'sku_model',            // Model
// //         'remark',               // Remark
// //         'verification',         // Verification
// //         'status',               // Status
// //         'main_priority'         // Main Priority
// //     )
// //     ->get()
// //     ->map(function ($item) {
// //         return [
// //             'bom_number'     => 'BM-00114',         // hardcoded
// //             'sku_id'         => $item->sku_id,
// //             'sku_name'       => $item->sku_name,
// //             'sku_model'      => $item->sku_model,
// //             'remark'         => $item->remark,
// //             'verification'   => $item->verification,
// //             'status'         => $item->status,
// //             'main_priority'  => $item->main_priority,
// //         ];
// //     });
// // }

// protected $rows;
//     public function __construct($rows) {
//         $this->rows = $rows;
//     }

//     public function collection()
//     {
//         return collect($this->rows);
//     }

//    public function headings(): array
//     {
//         return [
//             'Bom Number',
//             'Part Code',
//             'Part Name',
//             'Model',
//             'Remark',
//             'Verification',
//             'Status',
//             'Main Priority',
//         ];
//     }


    
// }
class BomExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $rows;

    public function __construct($rows) {
        $this->rows = $rows;
    }

    public function collection()
    {
        return collect($this->rows)->map(function ($bom) {
            return [
                'BM-' . str_pad($bom->id, 5, '0', STR_PAD_LEFT),
                $bom->sku_id,
                $bom->sku_name,
                $bom->sku_model,
                $bom->remark,
                $bom->verification,
                $bom->status,
                $bom->main_priority,
            ];
        });
    }
    

    public function headings(): array
    {
        return [
            // Baris ke-2 (judul utama)
            ['BOM Number', 'Part Code', 'Part Name', 'Model', 'Remark', 'Verification', 'Status', 'Main Priority'],
            
        ];
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function(\Maatwebsite\Excel\Events\AfterSheet $event) {
                $sheet = $event->sheet;

                // Tambah header grup di baris pertama
                $sheet->insertNewRowBefore(1, 1); // Sisipkan baris di atas headings()

                // Tulis header grup
                $sheet->setCellValue('A1', '');
                $sheet->setCellValue('B1', 'Part Information');
                $sheet->mergeCells('B1:E1');

                $sheet->setCellValue('F1', 'BOM Status');
                $sheet->mergeCells('F1:H1');

                $sheet->setCellValue('A4', '');
                $sheet->setCellValue('B4', 'Production Material Information');
                $sheet->mergeCells('B4:H4');

                $sheet->setCellValue('I4', 'Cost');
                $sheet->mergeCells('I4:M4');

                


                // Styling (opsional)
                $sheet->getStyle('A1:H2')->getFont()->setBold(true);
                $sheet->getStyle('A1:H2')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A1:H2')->getAlignment()->setVertical('center');

                $sheet->getStyle('A4:M5')->getFont()->setBold(true);
                $sheet->getStyle('A4:M5')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A4:M5')->getAlignment()->setVertical('center');
            },
        ];
    }
}
