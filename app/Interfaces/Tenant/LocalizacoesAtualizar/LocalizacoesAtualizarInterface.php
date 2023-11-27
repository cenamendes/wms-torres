<?php

namespace App\Interfaces\Tenant\LocalizacoesAtualizar;

use App\Http\Requests\Tenant\Localizacoes\LocalizacoesFormRequest;
use App\Models\Tenant\Localizacoes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface LocalizacoesAtualizarInterface
{
    
       /*** Localizações ***/

    public function getCodBarrasLocalizacoesInformation($codBarras);

    public function changeCodBarrasLocation($oldCodBarras, $newCodBarras): object;


    /***************** */

}
