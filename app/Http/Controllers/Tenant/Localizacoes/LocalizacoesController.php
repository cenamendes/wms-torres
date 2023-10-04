<?php

namespace App\Http\Controllers\Tenant\Localizacoes;


use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Interfaces\Tenant\Customers\CustomersInterface;
use App\Interfaces\Tenant\Localizacoes\LocalizacoesInterface;
use App\Http\Requests\Tenant\Localizacoes\LocalizacoesFormRequest;
use App\Models\Tenant\Localizacoes;

class LocalizacoesController extends Controller
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
        return view('tenant.localizacoes.localizacoes', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
        ]);
    }

    public function create(): View
    {
        $themeAction = 'form_element';
        return view('tenant.localizacoes.create',["themeAction" => $themeAction]);
    }

    public function edit($id): View
    {
        $themeAction = 'form_element';
    
        $response = Localizacoes::where('id',$id)->first();

        $cod_barras = $response->cod_barras;
        $descricao = $response->descricao;
        $abreviatura = $response->abreviatura;


        return view('tenant.localizacoes.edit',["themeAction" => $themeAction, "loc" => $id, "codbarras" => $cod_barras, "descricao" => $descricao, "abreviatura" => $abreviatura]);
    }

    public function store(LocalizacoesFormRequest $request) : RedirectResponse
    {
        $this->localizacoesRepository->add($request);
     
        return to_route('tenant.locations.index')
        ->with('message', __('Localização criada com sucesso!'))
        ->with('status', 'sucess');
    }

    public function update(LocalizacoesFormRequest $request) : RedirectResponse
    {
        $this->localizacoesRepository->updateLocation($request);
     
        return to_route('tenant.locations.index')
        ->with('message', __('Localização atualizada com sucesso!'))
        ->with('status', 'sucess');
    }

    public function destroy(int $idLocation)
    {
        $this->localizacoesRepository->deleteLocation($idLocation);

        return to_route('tenant.locations.index')
        ->with('message', __('Localização eliminada com sucesso!'))
        ->with('status', 'sucess');
    }

   

}
