<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ProductPrices extends Component
{
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
