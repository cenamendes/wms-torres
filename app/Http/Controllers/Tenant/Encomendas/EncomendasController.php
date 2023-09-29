<?php

namespace App\Http\Controllers\Tenant\Encomendas;


use Illuminate\View\View;
use App\Models\Tenant\Encomendas;
use App\Http\Controllers\Controller;
use App\Interfaces\Tenant\Customers\CustomersInterface;


class EncomendasController extends Controller
{
    private CustomersInterface $customersRepository;

    public function __construct()
    {
        
    }

    /**
     * Display the customers list.
     *
     * @return \Illuminate\View\View
     */
   

    public function rececao(): View
    {
        return view('tenant.encomendas.rececao', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
        ]);
    }

    public function detailEncomenda($numero_encomenda): View
    {
        //$encomenda = Encomendas::where('id',$numero_encomenda)->first();

        return view('tenant.encomendas.detailEncomenda', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
            'encomenda' => $numero_encomenda
        ]);
    }


   

}
