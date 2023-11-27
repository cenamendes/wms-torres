<?php

namespace App\Interfaces\Tenant\CodBarrasAtualizar;

use App\Http\Requests\Tenant\Localizacoes\LocalizacoesFormRequest;
use Illuminate\Pagination\LengthAwarePaginator;


interface CodBarrasAtualizarInterface
{
    
       /*** Localizações ***/

    public function getCodBarrasInformation($codBarras): object;

    public function changeCodBarrasProduct($oldCodBarras, $newCodBarras): object;


    /***************** */

}
