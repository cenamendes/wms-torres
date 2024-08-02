<?php

namespace App\Http\Controllers\Tenant\Entrada;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Interfaces\Tenant\Customers\CustomersInterface;

class EntradaController extends Controller
{

    public function entrada(): View
    {
        return view('tenant.entrada.entrada', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
        ]);
    }

}
