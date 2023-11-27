<?php

namespace App\Http\Controllers\Tenant\CodBarrasAtualizar;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Interfaces\Tenant\Customers\CustomersInterface;
use App\Interfaces\Tenant\Localizacoes\LocalizacoesInterface;
use App\Http\Requests\Tenant\Localizacoes\LocalizacoesFormRequest;
use App\Models\Tenant\Localizacoes;

class CodBarrasAtualizarController extends Controller
{
  
    
    public function __construct()
    {
        
    }

    /**
     * Display the customers list.
     *
     * @return \Illuminate\View\View
     */
   
    public function index(): View
    {
        return view('tenant.codbarrasatualizar.index', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
        ]);
    }

     

    

   

}
