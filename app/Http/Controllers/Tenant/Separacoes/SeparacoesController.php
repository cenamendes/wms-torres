<?php

namespace App\Http\Controllers\Tenant\Separacoes;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Interfaces\Tenant\Customers\CustomersInterface;
use App\Interfaces\Tenant\Localizacoes\LocalizacoesInterface;
use App\Http\Requests\Tenant\Localizacoes\LocalizacoesFormRequest;
use App\Models\Tenant\Localizacoes;

class SeparacoesController extends Controller
{
  
    private LocalizacoesInterface $localizacoesRepository;

    public function __construct(LocalizacoesInterface $interfaceLocalizacoes)
    {
        $this->localizacoesRepository = $interfaceLocalizacoes;
    }

    /**
     * Display the customers list.
     *
     * @return \Illuminate\View\View
     */
   
    public function index(): View
    {
        return view('tenant.separacoes.index', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
        ]);
    }

    public function detailEncomendaSeparacao($numero_encomenda): View
    {
        //$encomenda = Encomendas::where('id',$numero_encomenda)->first();

        return view('tenant.separacoes.detailEncomendaSeparacao', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
            'encomenda' => $numero_encomenda
        ]);
    }

   

}
