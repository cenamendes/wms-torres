<?php

namespace App\Interfaces\Tenant\Separacoes;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


interface SeparacoesInterface
{
    
    /** Arrumacoes */

    public function getEncomendasSeparacoes($perPage): LengthAwarePaginator;

    public function getEncomendasSeparacoesSearch($searchString,$perPage): LengthAwarePaginator;


    /*** Parte dos Detalhes */

    public function encomendaSeparacoesMovimentos($stamp,$perPage): LengthAwarePaginator;

    public function encomendaDetailAll($stamp): object;

    public function getEncomendaSeparacaoByStamp($stamp): object;


}
