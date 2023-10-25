<?php

namespace App\Interfaces\Tenant\Arrumacoes;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


interface ArrumacoesInterface
{
    
    /** Arrumacoes */

    public function getArrumacoes($perPage): LengthAwarePaginator;

    public function getArrumacoesCollection(): array;


}
