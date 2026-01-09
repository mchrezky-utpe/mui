<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Transaction\{
    ProductPrice as MainModel,
};
use App\Models\Master\General\GeneralCurrency;
use App\Models\MasterSku;
use Illuminate\Support\Facades\Validator;

class ProductPrices extends Component
{
    public array 
        $main_datas = [], 
        $currencies = [],

        $part_informations = [],
        $productton_materials = [],
        $general_items = [];
    
    protected $validator_rules = [
        "manual_id" => "nullable|max:50",
        "mst_sku_id" => "in:mst_sku",
        "customor_id" => "nullable",
        "project_code" => "nullable",
        "part_number" => "required|max:50",
        "general_currency_id" => "in:mst_general_currency",
        "price" => "required",
        "retail_price" => "required",
        "effective_from" => "required",
        "effective_to" => "required",
        "is_amortization" => "required",
        "is_activated" => "required",
    ];

    public function mount() {
        $this->currencies = GeneralCurrency::forSelect()->get()->toArray();
    }
    
    public function render()
    {
        return view('livewire.pages.product-prices', [
            "breadcrumbs" => [
                "#1" => "Transaction",
                "#2" => "SKU",
                "#3" => "Product Price",
            ]
        ]);
    }

    public function add(array $froms) {
        $validated = Validator::make($froms, $this->validator_rules)->validate();

        MainModel::create($validated);

        $this->dispatch("notify", [
            "variant" => "success",
            "title" => "Success",
            "message" => "Data berhasil ditambahkan."
        ]);
    }

    public function edit(array $froms) {
        $validated = Validator::make($froms, $this->validator_rules)->validate();

        MainModel::findOrFail($froms["id"])->update($validated);

        $this->dispatch("notify", [
            "variant" => "success",
            "title" => "Success",
            "message" => "Data berhasil diedit."
        ]);
    }

    public function remove(int $id) {
        MainModel::findOrFail($id)->delete();

        $this->dispatch("notify", [
            "variant" => "success",
            "title" => "Success",
            "message" => "Data berhasil dihapus."
        ]);
    }
    
}
