<?php

namespace App\Interfaces\Tenant\Transferencias;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


interface TransferenciasInterface
{
    
    public function getTransferenciasCollection(): array;

    public function getCodBarrasCollection(): array;


    //PARTE DA LISTAGEM

    public function getListagem($perPage): LengthAwarePaginator;

    public function getListagemSearch($searchString,$perPage): LengthAwarePaginator;


}
