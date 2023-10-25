<?php

namespace App\Interfaces\Tenant\Devolucoes;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


interface DevolucoesInterface
{
    
    public function getDevolucoesCollection(): array;

    public function getCodBarrasCollection(): array;


}
