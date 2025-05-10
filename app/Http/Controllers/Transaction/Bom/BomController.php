<?php

namespace App\Http\Controllers\Transaction\Bom;

use Illuminate\Http\Response;

class BomController
{


    public function index(): Response
    {
        return response()->view(
            'transaction.bom.edit',
            ['data' =>  null]
        );
    }
}