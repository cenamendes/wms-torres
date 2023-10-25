<?php

namespace App\Repositories\Tenant\Separacoes;

use stdClass;
use App\Models\Tenant\Encomendas;
use Illuminate\Support\Collection;
use App\Models\Tenant\Localizacoes;
use App\Models\Tenant\MovimentosStock;
use App\Models\Tenant\MovimentosStockTemporary;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Tenant\Arrumacoes\ArrumacoesInterface;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\Separacoes\SeparacoesInterface;

class SeparacoesRepository implements SeparacoesInterface
{
    
    public function getEncomendasSeparacoes($perPage): LengthAwarePaginator
    {

       $curl = curl_init();

       curl_setopt_array($curl, array(
           CURLOPT_URL => 'http://phc.brvr.pt:25002/orders/orders',
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

       
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if($response_decoded != null)
        {
            $currentItems = array_slice($response_decoded->orders, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$response_decoded->orders),$perPage);
        }
        else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$currentItems),$perPage);
        }     
    

        return $itemsPaginate;
    }

 
    public function getEncomendasSeparacoesSearch($searchString,$perPage): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.brvr.pt:25002/orders/orders',
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



        $new_object = new stdClass();
        $new_object->orders = [];


        foreach($response_decoded->orders as $resp)
        {
            if($resp->order_number == $searchString)
            {
                array_push($new_object->orders,$resp);
            }
        }



        $currentPage = LengthAwarePaginator::resolveCurrentPage();


        if($new_object != null)
        {
            $currentItems = array_slice($new_object->orders, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$new_object->orders),$perPage);
        }
        else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$currentItems),$perPage);
        }
        

        return $itemsPaginate;
    }



    public function encomendaSeparacoesMovimentos($stamp,$perPage): LengthAwarePaginator
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.brvr.pt:25002/orders/orders_lines?stamp='.trim($stamp),
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


     

       // $new_object = new stdClass();
        //$new_object->lines = [];

        //$countSearchString = strlen($stamp);

        // foreach($response_decoded->lines as $resp)
        // {
        //     if(trim($resp->stamp) == trim($stamp))
        //     {
        //         array_push($new_object->lines,$resp);
        //     }
        // }



        $currentPage = LengthAwarePaginator::resolveCurrentPage();


        if($response_decoded != null)
        {
            $currentItems = array_slice($response_decoded->lines, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$response_decoded->lines),$perPage);
        }
        else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array)$currentItems),$perPage);
        }
        

        return $itemsPaginate;
    }


    public function encomendaDetailAll($stamp): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.brvr.pt:25002/orders/orders_lines?stamp='.trim($stamp),
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


        $new_object = new stdClass();
        $new_object->lines = [];

        //$countSearchString = strlen($stamp);

        // foreach($response_decoded->lines as $resp)
        // {
        //     if(trim($resp->stamp) == trim($stamp))
        //     {
        //         array_push($new_object->lines,$resp);
        //     }
        // }
     


        return $response_decoded;
    }


    public function getEncomendaSeparacaoByStamp($stamp): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.brvr.pt:25002/orders/orders',
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


        $new_object = new stdClass();
        $new_object->orders = [];


        foreach($response_decoded->orders as $resp)
        {
            if($resp->stamp == $stamp)
            {
                array_push($new_object->orders,$resp);
            }
        }
        

        return $new_object;
    }
  
   

}

