<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Transaction\{
    ProductPrice,
};
use App\Models\Master\General\GeneralCurrency;

class ProductPrices extends Component
{
    public array $currencies;

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
    
}
