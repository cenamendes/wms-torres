<?php

namespace App\Repositories\Tenant\Encomendas;

use App\Models\Tenant\Encomendas;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Models\Tenant\MovimentosStockTemporary;
use Illuminate\Support\Collection;

class EncomendasRepository implements EncomendasInterface
{
    
    public function getEncomendas($perPage): LengthAwarePaginator
    {
        $types = Encomendas::paginate($perPage);

        return $types;
    }

    public function getEncomendasSearch($searchString,$perPage): LengthAwarePaginator
    {
        $types = Encomendas::where('numero_encomenda', 'like', '%' . $searchString . '%')->paginate($perPage);
        return $types;
    }

    public function encomendaDetail($nr_encomenda,$perPage): LengthAwarePaginator
    {
        $types = Encomendas::where('id', $nr_encomenda)->paginate($perPage);
        return $types;
    }

    public function encomendaMovimentos($nr_encomenda,$perPage): LengthAwarePaginator
    {
        
        $encomendas = Encomendas::where('id',$nr_encomenda)->first();

        $arrayEnc = [];

       
    
        foreach(json_decode($encomendas->linhas_encomenda) as $line)
        {
            array_push($arrayEnc,$line);
        }
        

         $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if($arrayEnc != null)
        {
            $currentItems = array_slice($arrayEnc, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$arrayEnc),$perPage);
        }
        else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$currentItems),$perPage);
        }


        return $itemsPaginate;





        // $arrumacoes = Encomendas::all();

        // $referencias = [];

        // foreach($arrumacoes as $arr)
        // {
        //     foreach(json_decode($arr->linhas_encomenda) as $lines)
        //     {
        //         array_push($referencias,$lines);
        //     }
        // }

        // $verLocalizacoes = Localizacoes::all();
        // $arrayLocal = [];

        // foreach($verLocalizacoes as $local)
        // {
        //     if($local->id == "1")
        //     {   
        //         //$arrayLocal[$local->abreviatura] = [];
        //         foreach($referencias as $r => $ref)
        //         {
        //             $check = MovimentosStock::where('reference',$ref->referencias)->where('localizacao',$local->id)->get();
        //             $soma = 0;
        //             foreach($check as $i => $ch)
        //             {
        //                 $soma += $ch->qtd; 
        //                 $arrayLocal[$ref->referencias] = ["nr_encomenda" => $ch->nr_encomenda,"cod_barras" => $ch->cod_barras,"reference" => $ch->reference, "designacao" => $ref->designacoes, "qtd" => $soma, "local" => $local->abreviatura];                   
        //             }
                    
        //         }
        //     }
        // }

        // $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // if($arrayLocal != null)
        // {
        //     $currentItems = array_slice($arrayLocal, $perPage * ($currentPage - 1), $perPage);

        //     $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$arrayLocal),$perPage);
        // }
        // else {

        //     $currentItems = [];

        //     $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$currentItems),$perPage);
        // }


       
        //dd($itemsPaginate);



        return $itemsPaginate;
    }

    public function encomendaDetailAll($nr_encomenda): Collection
    {
        $types = Encomendas::where('id', $nr_encomenda)->get();
        return $types;
    }

    public function getLocalizacoes($perPage): LengthAwarePaginator
    {
        $types = Encomendas::paginate($perPage);

        return $types;
    }

    public function getCodBarras($reference): object
    {
        //$result_encoded = json_encode($object);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.brvr.pt:25002/products/product?reference='.$reference,
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


        //A RESPONSE SERÁ UMA STRING QUE VOU PASSAR O CODIGO DE BARRAS

        return $response_decoded;
    }

   

}

