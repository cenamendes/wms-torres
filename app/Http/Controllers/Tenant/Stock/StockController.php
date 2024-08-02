<?php

namespace App\Http\Controllers\Tenant\Stock;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Interfaces\Tenant\Customers\CustomersInterface;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;

class StockController extends Controller
{

    public EncomendasInterface $encomendasRepository;

    public function __construct(EncomendasInterface $encomendasinterface)
     {
      $this->encomendasRepository = $encomendasinterface;
     }

    public function stock(): View
    {
        return view('tenant.stock.stock', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
        ]);
    }

    // public function saidadetail($numero_encomenda): View
    // {
    //     //$encomenda = Encomendas::where('id',$numero_encomenda)->first();

    //     // $document = $this->encomendasRepository->entradaNumSaidas($numero_encomenda);

    //     return view('tenant.saidas.saidaDetail', [
    //         'themeAction' => 'form_element_data_table',
    //         'status' => session('status'),
    //         'message' => session('message'),
    //         'encomenda' => $numero_encomenda,
    //         // 'document' => $document
    //     ]);
    // }

}
