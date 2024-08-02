<?php

namespace App\Http\Controllers\Tenant\Saidas;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Interfaces\Tenant\Customers\CustomersInterface;
use App\Models\Tenant\Devolucoes;
use App\Models\Tenant\SaidasStock;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;

class SaidaController extends Controller
{

    public EncomendasInterface $encomendasRepository;

    public function __construct(EncomendasInterface $encomendasinterface)
     {
      $this->encomendasRepository = $encomendasinterface;
     }

    public function saida($idsaida): View
    {
        return view('tenant.saidas.saida', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
            'saida' => $idsaida,
        ]);
    }

    public function saidadetail($numero_encomenda): View
    {
        //$encomenda = Encomendas::where('id',$numero_encomenda)->first();
        $document = $this->encomendasRepository->entradaNumSaidas($numero_encomenda);
        $userPreview = SaidasStock::where('document', intval($document))->first();

        return view('tenant.saidas.saidadetail', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
            'encomenda' => $numero_encomenda,
            'document' => $document,
            'userPreview' => $userPreview
        ]);
    }

}
