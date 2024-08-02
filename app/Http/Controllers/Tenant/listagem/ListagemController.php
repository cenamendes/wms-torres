<?php

namespace App\Http\Controllers\Tenant\Transferencias;


use Illuminate\View\View;
use App\Models\Tenant\Transferencias;
use App\Http\Controllers\Controller;
use App\Interfaces\Tenant\Customers\CustomersInterface;


class ListagemController extends Controller
{


    public function __construct()
    {

    }

    /**
     * Display the customers list.
     *
     * @return \Illuminate\View\View
     */

    public function listagemdetail($numero_encomenda): View
    {
        //$encomenda = Encomendas::where('id',$numero_encomenda)->first();

        return view('tenant.transferencias.detailListagem', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
            'encomenda' => $numero_encomenda
        ]);
    }




}

