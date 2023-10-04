<?php

namespace App\Interfaces\Tenant\Localizacoes;

use App\Http\Requests\Tenant\Localizacoes\LocalizacoesFormRequest;
use Illuminate\Pagination\LengthAwarePaginator;


interface LocalizacoesInterface
{
    
       /*** Localizações ***/

    public function getLocalizacoes($perPage): LengthAwarePaginator;

    public function getLocalizacoesSearch($searchString,$perPage): LengthAwarePaginator;

    public function add(LocalizacoesFormRequest $request);

    public function updateLocation(LocalizacoesFormRequest $request);

    public function deleteLocation($id);

    /***************** */

}
