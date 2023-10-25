<?php

namespace App\Repositories\Tenant\Arrumacoes;

use App\Models\Tenant\Encomendas;
use Illuminate\Support\Collection;
use App\Models\Tenant\Localizacoes;
use App\Models\Tenant\MovimentosStock;
use App\Models\Tenant\MovimentosStockTemporary;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Tenant\Arrumacoes\ArrumacoesInterface;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;

class ArrumacoesRepository implements ArrumacoesInterface
{
    
    public function getArrumacoes($perPage): LengthAwarePaginator
    {
        $arrumacoes = Encomendas::all();

        $referencias = [];

        foreach($arrumacoes as $arr)
        {
            foreach(json_decode($arr->linhas_encomenda) as $lines)
            {
                array_push($referencias,$lines);
            }
        }

        $verLocalizacoes = Localizacoes::all();
        $arrayLocal = [];

        foreach($verLocalizacoes as $local)
        {
            if($local->id == "1")
            {   
                //$arrayLocal[$local->abreviatura] = [];
                foreach($referencias as $r => $ref)
                {
                    $check = MovimentosStock::where('reference',$ref->referencias)->where('localizacao',$local->id)->get();
                    $soma = 0;
                    foreach($check as $i => $ch)
                    {
                        $soma += $ch->qtd; 
                        $arrayLocal[$ref->referencias] = ["nr_encomenda" => $ch->nr_encomenda,"cod_barras" => $ch->cod_barras,"reference" => $ch->reference, "designacao" => $ref->designacoes, "qtd" => $soma, "local" => $local->abreviatura];                   
                    }
                    
                }
            }
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if($arrayLocal != null)
        {
            $currentItems = array_slice($arrayLocal, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$arrayLocal),$perPage);
        }
        else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$currentItems),$perPage);
        }


       
        //dd($itemsPaginate);



        return $itemsPaginate;
    }

    public function getArrumacoesCollection(): array
    {
        $arrumacoes = Encomendas::all();

        $referencias = [];

        foreach($arrumacoes as $arr)
        {
            foreach(json_decode($arr->linhas_encomenda) as $lines)
            {
                array_push($referencias,$lines);
            }
        }

        $verLocalizacoes = Localizacoes::all();
        $arrayLocal = [];

        foreach($verLocalizacoes as $local)
        {
            if($local->id == "1")
            {   
                //$arrayLocal[$local->abreviatura] = [];
                foreach($referencias as $r => $ref)
                {
                    $check = MovimentosStock::where('reference',$ref->referencias)->where('localizacao',$local->id)->get();
                    $soma = 0;
                    foreach($check as $i => $ch)
                    {
                        $soma += $ch->qtd; 
                        $arrayLocal[$ref->referencias] = ["nr_encomenda" => $ch->nr_encomenda,"cod_barras" => $ch->cod_barras,"reference" => $ch->reference, "designacao" => $ref->designacoes, "qtd" => $soma, "local" => $local->abreviatura];                   
                    }
                    
                }
            }
        }


        return $arrayLocal;
    }
 

  
   

}

