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
        $q = $request->get('q', '');
        $type = $request->get('type', 1);
        $date = $request->get('date', '');

        $data = StockOpening::when($q, function ($query, $q) {
                    $query->where(function ($sub) use ($q) {
                        $sub->where('description', 'like', "%{$q}%")
                            ->orWhere('specification_code', 'like', "%{$q}%");
                    });
                })
                ->when($type, function ($query, $type) {
                    $query->where('flag_sku_type', $type);
                })
                ->when($date, function ($query, $date) {
                    $query->whereDate('created_at', $date);
                })
                ->paginate(100)
                ->appends([
                    'q' => $q,
                    'type' => $type,
                    'date' => $date,
                ]);

        return view('transaction.inventory.stock_opening.data', [
            'data' => $data,
            'q' => $q,
            'type' => $type,
            'date' => $date,
            'pagination' => $data->links('vendor.pagination.custome'),
        ]);
    }

    
}
