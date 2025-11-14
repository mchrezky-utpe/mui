<?php

namespace App\Http\Controllers\Transaction\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction\Inventory\StockOpening; 

class StockOpeningController extends Controller
{
    
     public function index()
    {
         $data = [
            'title'   => 'stock_opening',
            'css'     => 'transaction/inventory/stock_opening/css',
            'content' => 'transaction/inventory/stock_opening/index',
            'script'  => 'transaction/inventory/stock_opening/script',
        ];

        return view('transaction/inventory/stock_opening/index', $data);
    }
    
    public function data(Request $request)
    {
       
        $q = $request->input('q', '');
        $type = $request->input('type', 1);
        $date = $request->input('date', '');

        // Pilihan view berdasarkan type
        $views = [
            1 => 'transaction.inventory.stock_opening.part',
            2 => 'transaction.inventory.stock_opening.production',
            3 => 'transaction.inventory.stock_opening.general',
            4 => 'transaction.inventory.stock_opening.returnable',
        ];

        // Default query (untuk type 1-3)
        $query = StockOpening::query();

        // Kondisi untuk type Returnable Packaging
        if ($type == 4) {
            $data = StockOpening::returnablePackagingView()->get();

        } else {
            // Untuk Part, Production, General
            $data = $query
                ->when($q, function ($query, $q) {
                    $query->where(function ($sub) use ($q) {
                        $sub->where('description', 'like', "%$q%")
                            ->orWhere('manual_id', 'like', "%$q%");
                    });
                })
                ->when($date, function ($query, $date) {
                    $query->whereDate('created_at', $date);
                })
                ->where('flag_sku_type', $type)
                ->paginate(10);
        }

        // Tentukan view sesuai type
        $view = $views[$type] ?? $views[1];

        return view($view, [
            'data' => $data,
            'q' => $q,
            'type' => $type,
            'date' => $date,
        ]);

    }

    
}
