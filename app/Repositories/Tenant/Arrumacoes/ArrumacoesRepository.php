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
    public $encomendasRepository;

    public function boot(EncomendasInterface $interfaceEncomendas)
    {
        $this->encomendasRepository = $interfaceEncomendas;
    }
    

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

                        $curl = curl_init();

                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'http://phc.brvr.pt:25002/products/product?reference='.$ch->reference,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                            ),
                        ));
                    
                        $response = curl_exec($curl);
                    
                        $response_decoded = json_decode($response);

                       
                       if(!isset($response_decoded->ordered))
                       {
                            $soma = $soma;
                       }
                       else
                       {
                            $soma = $soma - $response_decoded->ordered;
                       }
                        
                        
                        // if( $soma > $response_decoded->stock)
                        // {
                        //     $soma = $response_decoded->stock;
                        // }


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

