<?php

namespace App\Repositories\Tenant\CodBarrasAtualizar;


use App\Models\Tenant\Encomendas;
use App\Models\Tenant\Localizacoes;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\CodBarrasAtualizar\CodBarrasAtualizarInterface;
use App\Http\Requests\Tenant\Localizacoes\LocalizacoesFormRequest;
use stdClass;

class CodBarrasAtualizarRepository implements CodBarrasAtualizarInterface
{
    
    public function getCodBarrasInformation($codBarras): object
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.brvr.pt:25002/products/product?reference='.$codBarras,
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

        curl_close($curl);

        $decoded = json_decode($response);

        return $decoded;
    }


    public function changeCodBarrasProduct($oldCodBarras, $newCodBarras): object
    {

        $array = ["referense_barcode" => $oldCodBarras, "new_barcode" => $newCodBarras];

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.brvr.pt:25002/products/barcode',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => json_encode($array),
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
            ),
        ));
    
        $response = curl_exec($curl);

        curl_close($curl);

        $decoded = json_decode($response);

        return $decoded;


    }
   

}

