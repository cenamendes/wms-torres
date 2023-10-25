<?php

namespace App\Interfaces\Tenant\Encomendas;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EncomendasInterface
{
    
    /** Encomendas */

    public function getEncomendas($perPage): LengthAwarePaginator;

    public function getEncomendasSearch($searchString,$perPage): LengthAwarePaginator;


    /************/

    /*** Encomenda Detalhada ****/

    public function encomendaDetail($nr_encomenda,$perPage): LengthAwarePaginator;

    public function encomendaDetailAll($nr_encomenda): Collection;

    public function encomendaMovimentos($nr_encomenda,$perPage): LengthAwarePaginator;

    /******** */

    public function getCodBarras($reference): object;


}
