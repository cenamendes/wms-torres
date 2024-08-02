<?php

namespace App\Interfaces\Tenant\Encomendas;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EncomendasInterface
{

    /** Encomendas */

    public function getEncomendas($perPage): LengthAwarePaginator;
    public function getEncomendasSearch($searchString, $ordenation, $perPage, $zona, $designacao): LengthAwarePaginator;
    public function getSaidasSearch($id, $searchString, $ordenation, $perPage, $designacao): LengthAwarePaginator;
    public function getDevolucoesclientesSearch($searchString, $ordenation, $perPage, $zona, $designacao): LengthAwarePaginator;
    public function getDevolucoesdanificadoSearch($searchString, $ordenation, $perPage, $zona, $designacao): LengthAwarePaginator;


    /************/

    /*** Encomenda Detalhada ****/

    public function encomendaDetail($nr_encomenda,$perPage): LengthAwarePaginator;

    public function encomendaDetailAll($nr_encomenda): Collection;

    public function encomendaMovimentos($nr_encomenda,$perPage): LengthAwarePaginator;

    public function encomendaImprimir($nr_encomenda,$reference): array;

    /******** */

    public function entradasCodBarras($perPage): LengthAwarePaginator;
    public function verificarEncomendasarmazem($id, $perPage): LengthAwarePaginator;

    public function entradaNumEncomenda($id): ?string;
    public function entradaNumDevolucoesClientes($id): ?string;
    public function entradaNumDevolucoesDanificado($id): ?string;
    public function entradaNumSaidas($id): ?string;
    public function detalhesCodBarras($id, $perPage): LengthAwarePaginator;

    public function  conferecod($id): object;

    public function saidasconfcod($id): object;

    public function devoluclientconferecod($id): object;

    public function devolumaterialconferecod($id): object;

    public function  guardstock($id): object;

    public function saidasguardstock($id): object;

    public function devolclientguardstock($id): object;

    public function devolmaterialguardstock($id): object;

    public function  checkmassa($id): object;

    public function entradaQtdStock($id): string;

    public function saidasQtdStock($id): string;
    public function devolclientQtdStock($id): string;
    public function devolmaterialQtdStock($id): string;


    public function menusaidas(): object;
    public function entradarefsaidas($id, $perpage): LengthAwarePaginator;
    public function saidasbancodados($id): object;
    public function detalhesSaidas($id,$perPage): LengthAwarePaginator;


    public function devolucoesClientesCodBarras($perPage): LengthAwarePaginator;
    public function detalhesdevolucoesclientes($id,$perPage): LengthAwarePaginator;

    public function devolucoesMaterialDanificadoCodBarras($perPage): LengthAwarePaginator;
    public function detalhesdevolucoesmaterial($id,$perPage): LengthAwarePaginator;


    public function stock($id): string;



    public function selectStock(): object;


}
