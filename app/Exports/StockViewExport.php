<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\Master\Sku\SkuListVw;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class StockViewExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStrictNullComparison
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function collection()
    {
        if ($this->type !== 'Returnable Packaging') {
            $query = SkuListVw::from('vw_app_list_mst_sku as a')
                ->leftJoin('trans_sku_minofstock as b', 'b.sku_id', '=', 'a.id')
                ->where('a.flag_inventory_register', 1);

            if ($this->type) {
                $query->where('sku_type', $this->type);
            }

            $data = $query->selectRaw('a.sku_id, a.sku_name, a.sku_specification_code, a.sku_material_type, a.sku_classification, a.sku_sales_category, a.sku_inventory_unit, a.val_conversion, b.qty as min_qty')
                ->selectSub(function ($q) {
                    $q->from('trans_sales_order_details as aa')
                        ->selectRaw('SUM(aa.outstanding)')
                        ->whereColumn('aa.sku_id', 'a.id')
                        ->where('aa.outstanding', '>', 0);
                }, 'total_outstanding')
                ->get();

            $excelData = $data->map(function ($item) {
                return [
                    'sku_id' => $item->sku_id,
                    'sku_name' => $item->sku_name,
                    'sku_specification_code' => $item->sku_specification_code,
                    'sku_material_type' => $item->sku_material_type,
                    'sku_classification' => $item->sku_classification,
                    'sku_sales_category' => $item->sku_sales_category,
                    'sku_inventory_unit' => $item->sku_inventory_unit,
                    'val_conversion' => $item->val_conversion != null ? floatval($item->val_conversion) : floatval(0),
                    'total_outstanding' => $item->total_outstanding != null ? floatval($item->total_outstanding) : floatval(0),
                    'min_qty' => $item->min_qty != null ? floatval($item->min_qty) : floatval(0),
                    'max_qty' => floatval(0),
                    'msr' => floatval(0)
                ];
            });
        } else {
            $query = DB::table('mst_packaging_information_category as a')
                ->leftJoin('mst_sku_type as b', 'b.id', '=', 'a.type_id')
                ->leftJoin('mst_sku_model as c', 'c.id', '=', 'a.model_id')
                ->leftJoin('mst_sku_unit as d', 'd.id', '=', 'a.unit_id')
                ->leftJoin('mst_sku_sub_category as e', 'e.id', '=', 'b.sku_sub_category_id')
                ->where('e.description', 'RETURNABLE PACKAGING');

            $data = $query->select('a.id', 'a.description', 'a.category_size', 'b.description as type', 'c.description as model', 'd.description as unit', 'e.description as sub_category', 'a.total_stock')
                ->get();

            $excelData = $data->map(function ($item) {
                return [
                    'type' => $item->type,
                    'description' => $item->description,
                    'model' => $item->model,
                    'unit' => $item->unit,
                    'category_size' => $item->category_size,
                    'warehouse' => $item->total_stock != null ? floatval($item->total_stock) : floatval(0),
                    'outside' => floatval(0)
                ];
            });
        }

        return $excelData;
    }

    public function headings(): array
    {
        if ($this->type === 'Returnable Packaging') {
            return [
                'Packaging Type',
                'Packaging Name',
                'Model',
                'Packaging Unit',
                'Category Size',
                'Warehouse',
                'Outside',
            ];
        }
        return [
            'Item Code',
            'Item Name',
            'Specification Code',
            'Item Type',
            'Item Classification',
            'Sales Category',
            'Unit',
            'Warehouse',
            'Supplier',
            'Min',
            'Max',
            'MSR'
        ];
    }
}
