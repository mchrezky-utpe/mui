<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Sidebar extends Component
{
    public array $breadcrumbs = [];
    // example: ['master' => 'Master', 'master\sku' => 'SKU', 'master\sku\bom' => 'BOM']

    /**
     * Create a new component instance.
     */
    public function __construct()
    {

        if (empty($this->breadcrumbs)) {
            $segments = request()->segments();

            $uris = '';

            $this->breadcrumbs = collect($segments)->map(function ($segment) {
                global $uris;
                $uris .= $segment;

                return [$uris => $segment];
            })->toArray();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrump');
    }
}

// class Sidebar extends Component
// {
//     public array $breadcrumbs = [];
//     public array $paths;

//     /**
//      * Create a new component instance.
//      */
//     public function __construct()
//     {
//         if (empty($this->breadcrumbs)) {
//             $this->breadcrumbs = request()->segments();
//         }

//         $this->paths = [];
//         $breads = [];

//         foreach ($this->breadcrumbs as $index => $bread) {
//             // $breads[] = preg_replace_callback("/\W\w/", fn($s) => Str::upper($s), preg_filter("/\-/", " ", $bread) ?? $bread);
//             $breads[] = Str::upper(preg_filter("/\-/", " ", $bread) ?? $bread);

//             $prev_path = $index > 0 ? $this->paths[$index - 1] : '';
//             $this->paths[] = "{$prev_path}/{$bread}";
//             // $this->paths[] = $prev_path . '/' . Str::slug($bread);
//         }

//         $this->breadcrumbs = $breads;
//     }

//     /**
//      * Get the view / contents that represent the component.
//      */
//     public function render(): View|Closure|string
//     {
//         return view('components.breadcrump');
//     }
// }
