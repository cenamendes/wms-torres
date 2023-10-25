<?php

namespace App\Http\Controllers\Tenant\Transferencias;


use Illuminate\View\View;
use App\Http\Controllers\Controller;


class TransferenciasController extends Controller
{
  
    /**
     * Display the customers list.
     *
     * @return \Illuminate\View\View
     */
   
    public function index(): View
    {
        return view('tenant.transferencia.index', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
        ]);
    }
   

}
