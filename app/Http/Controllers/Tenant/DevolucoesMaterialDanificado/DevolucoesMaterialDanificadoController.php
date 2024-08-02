<?php

namespace App\Http\Controllers\Tenant\DevolucoesMaterialDanificado;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Interfaces\Tenant\Customers\CustomersInterface;
use App\Models\Tenant\Devolucoes;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;

class DevolucoesMaterialDanificadoController extends Controller
{

    public EncomendasInterface $encomendasRepository;

    public function __construct(EncomendasInterface $encomendasinterface)
     {
      $this->encomendasRepository = $encomendasinterface;
     }

    public function devolucoesMaterialDanificado(): View
    {
        return view('tenant.devolucoesmaterialdanificado.devolucoesMaterialDanificado', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
        ]);
    }

    public function detailmaterialdanificado($numero_encomenda): View
    {
        //$encomenda = Encomendas::where('id',$numero_encomenda)->first();

        $document = $this->encomendasRepository->entradaNumDevolucoesDanificado($numero_encomenda);

        return view('tenant.devolucoesmaterialdanificado.detailMaterialDanificado', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
            'encomenda' => $numero_encomenda,
            'document' => $document
        ]);
    }

}
