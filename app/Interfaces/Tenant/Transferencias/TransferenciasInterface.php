<?php

namespace App\Interfaces\Tenant\Transferencias;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


interface TransferenciasInterface
{
    
    public function getTransferenciasCollection(): array;

    public function getCodBarrasCollection(): array;


}
