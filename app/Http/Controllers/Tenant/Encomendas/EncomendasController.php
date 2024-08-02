<?php

namespace App\Http\Controllers\Tenant\Encomendas;


use Illuminate\View\View;
use App\Models\Tenant\Encomendas;
use App\Http\Controllers\Controller;
use App\Interfaces\Tenant\Customers\CustomersInterface;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;

class EncomendasController extends Controller
{

    public EncomendasInterface $encomendasRepository;

   public function __construct(EncomendasInterface $encomendasinterface)
    {
     $this->encomendasRepository = $encomendasinterface;
    }


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

        $document = $this->encomendasRepository->entradaNumEncomenda($numero_encomenda);


        return view('tenant.encomendas.detailEncomenda', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
            'encomenda' => $numero_encomenda,
            'document' => $document
        ]);
    }




}

// <?php

// namespace App\Http\Controllers\Tenant\Encomendas;


// use Illuminate\View\View;
// use App\Models\Tenant\Encomendas;
// use App\Http\Controllers\Controller;
// use App\Interfaces\Tenant\Customers\CustomersInterface;
// use App\Interfaces\Tenant\Encomendas\EncomendasInterface;

// class EncomendasController extends Controller
// {

//     /**Detail */
//     private EncomendasInterface $encomendaRepository;

//     public function __construct(EncomendasInterface $encomendaRepository)
//     {
//         $this->encomendaRepository = $encomendaRepository;
//     }

//     /**
//      * Display the customers list.
//      *
//      * @return \Illuminate\View\View
//      */


//     public function rececao(): View
//     {
//         return view('tenant.encomendas.rececao', [
//             'themeAction' => 'form_element_data_table',
//             'status' => session('status'),
//             'message' => session('message'),
//         ]);
//     }

//     public function detailEncomenda($numero_encomenda): View

//     {
//         //$encomenda = Encomendas::where('id',$numero_encomenda)->first();
//         $encomendaDocument = $this->encomendaRepository->entradaNumEncomenda($numero_encomenda);

//         return view('tenant.encomendas.detailEncomenda', [
//             'themeAction' => 'form_element_data_table',
//             'status' => session('status'),
//             'message' => session('message'),
//             'encomendaDocument' => $numero_encomenda
//         ]);
//     }




// }
