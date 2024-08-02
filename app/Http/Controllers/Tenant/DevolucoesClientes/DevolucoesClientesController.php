<?php

namespace App\Http\Controllers\Tenant\DevolucoesClientes;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Interfaces\Tenant\Customers\CustomersInterface;
use App\Models\Tenant\Devolucoes;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;

class DevolucoesClientesController extends Controller
{

    public EncomendasInterface $encomendasRepository;

    public function __construct(EncomendasInterface $encomendasinterface)
     {
      $this->encomendasRepository = $encomendasinterface;
     }

    public function devolucoesClientes(): View
    {
        return view('tenant.devolucoesclientes.devolucoesClientes', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
        ]);
    }

    public function detaildevolucoesclientes($numero_encomenda): View
    {
        //$encomenda = Encomendas::where('id',$numero_encomenda)->first();

        $document = $this->encomendasRepository->entradaNumDevolucoesClientes($numero_encomenda);

        return view('tenant.devolucoesclientes.detailDevolucoesClientes', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
            'encomenda' => $numero_encomenda,
            'document' => $document
        ]);
    }
}
