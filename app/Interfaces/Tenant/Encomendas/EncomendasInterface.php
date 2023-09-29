<?php

namespace App\Interfaces\Tenant\Encomendas;

use Illuminate\Pagination\LengthAwarePaginator;


interface EncomendasInterface
{
    
    /** Encomendas */

    public function getEncomendas($perPage): LengthAwarePaginator;

    public function getEncomendasSearch($searchString,$perPage): LengthAwarePaginator;


    /************/

    /*** Encomenda Detalhada ****/

    public function encomendaDetail($nr_encomenda,$perPage): LengthAwarePaginator;

    /******** */


}
