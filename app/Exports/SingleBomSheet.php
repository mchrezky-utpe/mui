<?php
namespace App\Exports;

use App\Models\Master\Bom\BomDetail;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SingleBomSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
    protected $bom;

    public function __construct($bom)
    {
        $this->bom = $bom;
    }

    public function array(): array
    {
        $details = BomDetail::with('sku')->where('sku_bom_id', $this->bom->id)->get();
        $rows = [];

        foreach ($details as $index => $detail) {
            $rows[] = [
                $index + 1,
                $detail->sku->manual_id ?? '',
                $detail->sku->description ?? '',
                $detail->description,
                $detail->qty_capacity,
                $detail->qty_each_unit,
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return $this->bom->manual_id;
    }

    public function headings(): array
    {
        return [
            ['BOM Number:', $this->bom->manual_id],
            ['Part Code:', $this->bom->sku_manual_code ?? ''],
            ['Part Name:', $this->bom->sku_description ?? ''],
            ['Model:', $this->bom->sku_model ?? ''],
            [],
            ['Index', 'Material Code', 'Material Name', 'Description', 'Qty/Unit', 'Qty/Capacity'],
        ];
    }
}

?>