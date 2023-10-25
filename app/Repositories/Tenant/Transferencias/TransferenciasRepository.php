<?php

namespace App\Repositories\Tenant\Transferencias;

use App\Models\Tenant\Encomendas;
use Illuminate\Support\Collection;
use App\Models\Tenant\Localizacoes;
use App\Models\Tenant\MovimentosStock;
use App\Models\Tenant\MovimentosStockTemporary;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Tenant\Arrumacoes\ArrumacoesInterface;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\Transferencias\TransferenciasInterface;

class TransferenciasRepository implements TransferenciasInterface
{
    
    public function getTransferenciasCollection(): array
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

        $verLocalizacoes = Localizacoes::where('local_stock','1')->get();
        $arrayLocal = [];

        foreach($verLocalizacoes as $local)
        {
            // if($local->id != "1")
            // {   
                $arrayLocal[$local->cod_barras] = [];
                foreach($referencias as $r => $ref)
                {
                    $check = MovimentosStock::where('reference',$ref->referencias)->where('localizacao',$local->id)->get();
                    $soma = 0;
        
                    foreach($check as $i => $ch)
                    {
                        $soma += $ch->qtd; 
                        $arrayLocal[$local->cod_barras][$ref->referencias] = ["nr_encomenda" => $ch->nr_encomenda,"cod_barras" => $ch->cod_barras,"reference" => $ch->reference, "designacao" => $ref->designacoes, "qtd" => $soma, "local" => $local->abreviatura];                   
                    }
                    
                }
            //}
        }


        return $arrayLocal;
    }

    public function getCodBarrasCollection(): array
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
            // if($local->id != "1")
            // {   
        
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
            //}
        }


        return $arrayLocal;
    }
 

  
   

}

