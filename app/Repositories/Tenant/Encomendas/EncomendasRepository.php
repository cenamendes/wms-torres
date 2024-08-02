<?php

namespace App\Repositories\Tenant\Encomendas;

use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Models\Tenant\Encomendas;
use App\Models\Tenant\MovimentosStock;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EncomendasRepository implements EncomendasInterface
{

    /*encomendas*/

    public function getEncomendas($perPage): LengthAwarePaginator
    {
        $types = Encomendas::paginate($perPage);
        return $types;
    }

    public function getEncomendasSearch($searchString, $ordenation, $perPage, $zona, $designacao): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/purchase',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        $filteredResults = [];

        // Filtra os resultados com base na string de pesquisa
        foreach ($response_decoded->purchase as $resp) {
            if (isset($resp->document) && stripos($resp->document, $searchString) !== false) {
                $filteredResults[] = $resp;
            }
        }
        if (!empty($zona)) {
            $filteredResults = array_filter($filteredResults, function ($resp) use ($zona) {
                return $resp->zone == $zona;
            });
        }
        if (!empty($designacao)) {
            $filteredResults = array_filter($filteredResults, function ($resp) use ($designacao) {
                // Considerando que a designação está contida no campo <name> do endpoint
                return stripos($resp->name, $designacao) !== false;
            });
        }

        // Ordena os resultados com base na opção de ordenação
        if ($ordenation == 'asc') {
            usort($filteredResults, function ($a, $b) {
                return strtotime($a->date) - strtotime($b->date);
            });
        } else {
            usort($filteredResults, function ($a, $b) {
                return strtotime($b->date) - strtotime($a->date);
            });
        }

        // Pagina os resultados
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($filteredResults, $perPage * ($currentPage - 1), $perPage);
        $itemsPaginate = new LengthAwarePaginator($currentItems, count($filteredResults), $perPage);

        return $itemsPaginate;
    }

    /*Encomendas Detail*/

    public function encomendaDetail($nr_encomenda, $perPage): LengthAwarePaginator
    {
        $types = Encomendas::where('id', $nr_encomenda)->paginate($perPage);
        return $types;
    }

    public function encomendaMovimentos($nr_encomenda, $perPage): LengthAwarePaginator
    {

        $encomendas = Encomendas::where('id', $nr_encomenda)->first();

        $arrayEnc = [];

        foreach (json_decode($encomendas->linhas_encomenda) as $line) {
            array_push($arrayEnc, $line);
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($arrayEnc != null) {
            $currentItems = array_slice($arrayEnc, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $arrayEnc), $perPage);
        } else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $currentItems), $perPage);
        }

        return $itemsPaginate;
    }

    public function encomendaImprimir($nr_encomenda, $reference): array
    {
        $encomendas = MovimentosStock::where('numero_encomenda', $nr_encomenda)
            ->where('referencia', $reference)
            ->get();

        $arrayEnc = [];

        foreach ($encomendas as $line) {
            if ($line->referencia == $reference) {
                $arrayEnc[] = [
                    'referencia' => $line->referencia,
                    'qtd_separada' => $line->qtd_separada,
                ];
            }
        }

        return $arrayEnc;
    }

    public function encomendaDetailAll($nr_encomenda): Collection
    {
        $types = Encomendas::where('document', $nr_encomenda)->get();
        return $types;
    }

    public function getLocalizacoes($perPage): LengthAwarePaginator
    {
        $types = Encomendas::paginate($perPage);

        return $types;
    }

    public function entradasCodBarras($perPage): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/purchase',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($response_decoded != null) {
            $currentItems = array_slice($response_decoded->purchase, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $response_decoded->purchase), $perPage);
        } else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $currentItems), $perPage);
        }

        return $itemsPaginate;

    }

    public function verificarEncomendasarmazem($id, $perPage): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/purchase/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($response_decoded != null) {
            $currentItems = array_slice($response_decoded->lines, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $response_decoded->lines), $perPage);
        } else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $currentItems), $perPage);
        }

        return $itemsPaginate;
    }

    public function entradaNumEncomenda($id): ?string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/purchase/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        // Verificar se a resposta está vazia ou inválida
        if (!$response_decoded || !isset($response_decoded->lines)) {
            return null; // Ou lança uma exceção, dependendo do seu fluxo de tratamento de erros
        }

        // Iterar sobre as linhas da resposta e encontrar o documento da encomenda
        foreach ($response_decoded->lines as $item) {
            if ($item->id == $id) {
                return $item->document; // Retorna o documento da encomenda
            }
        }

        // Se a encomenda não for encontrada, retorne null ou lance uma exceção
        return null;
    }

    public function entradaQtdStock($id): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/products/products?referense=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded->products[0]->stock;
    }

    public function detalhesCodBarras($id, $perPage): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/purchase/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($response_decoded != null) {
            $currentItems = array_slice($response_decoded->lines, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $response_decoded->lines), $perPage);
        } else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $currentItems), $perPage);
        }

        return $itemsPaginate;
    }

    public function conferecod($id): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/purchase/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded;
    }

    public function guardstock($id): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/purchase/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded;
    }

    public function checkmassa($id): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/purchase/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded;
    }

//SAÍDAS
    public function menusaidas(): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/out/out_types',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded;
    }

    public function entradarefsaidas($id, $perPage): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/out/out_orders?type=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        if ($response_decoded !== null && property_exists($response_decoded, 'order')) {
            $currentPage = LengthAwarePaginator::resolveCurrentPage();

            $currentItems = array_slice($response_decoded->order, $perPage * ($currentPage - 1), $perPage);
            $totalItems = count((array) $response_decoded->order);

            $itemsPaginate = new LengthAwarePaginator($currentItems, $totalItems, $perPage);
        } else {
            // Caso a propriedade 'order' não exista ou a resposta seja nula
            $currentItems = [];
            $itemsPaginate = new LengthAwarePaginator($currentItems, 0, $perPage);
        }
        return $itemsPaginate;
    }

    public function saidasbancodados($id): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/out/out_orders?type=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded;
    }

public function entradaNumSaidas($id): ?string
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://phc.boxpt.com:443/out/out_lines?id='.$id,
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

    $response_decoded = json_decode($response);
    // Verificar se a resposta está vazia ou inválida
    if (!$response_decoded || !isset($response_decoded->lines)) {
        return null; // Ou lança uma exceção, dependendo do seu fluxo de tratamento de erros
    }

    // Iterar sobre as linhas da resposta e encontrar o documento da encomenda
    foreach ($response_decoded->lines as $item) {
        if ($item->id == $id) {
            return $item->document; // Retorna o documento da encomenda
        }
    }

    // Se a encomenda não for encontrada, retorne null ou lance uma exceção
    return null;
}

    public function getSaidasSearch($id, $searchString, $ordenation, $perPage, $designacao): LengthAwarePaginator
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/out/out_orders?type=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        $filteredResults = [];

        foreach ($response_decoded->order as $resp) {
            if (isset($resp->document) && stripos($resp->document, $searchString) !== false) {
                $filteredResults[] = $resp;
            }
        }

        if (!empty($designacao)) {
            $filteredResults = array_filter($filteredResults, function ($resp) use ($designacao) {
                return stripos($resp->name, $designacao) !== false;
            });
        }

        if ($ordenation == 'asc') {
            usort($filteredResults, function ($a, $b) {
                return strtotime($a->date) - strtotime($b->date);
            });
        } else {
            usort($filteredResults, function ($a, $b) {
                return strtotime($b->date) - strtotime($a->date);
            });
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($filteredResults, $perPage * ($currentPage - 1), $perPage);
        $itemsPaginate = new LengthAwarePaginator($currentItems, count($filteredResults), $perPage);

        return $itemsPaginate;

    }

    public function detalhesSaidas($id, $perPage): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/out/out_lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($response_decoded != null) {
            $currentItems = array_slice($response_decoded->lines, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $response_decoded->lines), $perPage);
        } else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $currentItems), $perPage);
        }

        return $itemsPaginate;
    }

    public function saidasQtdStock($id): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/products/products?referense=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded->products[0]->stock;
    }

    public function saidasconfcod($id): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/out/out_lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded;
    }

    public function saidasguardstock($id): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/out/out_lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded;
    }

    //DEVOLUÇÕES CLIENTES

    public function devolucoesClientesCodBarras($perPage): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return?type=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($response_decoded != null) {
            $currentItems = array_slice($response_decoded->customer_return, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $response_decoded->customer_return), $perPage);
        } else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $currentItems), $perPage);
        }

        return $itemsPaginate;
    }

    public function getDevolucoesclientesSearch($searchString, $ordenation, $perPage, $zona, $designacao): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return?type=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        $filteredResults = [];

        foreach ($response_decoded->customer_return as $resp) {
            if (isset($resp->document) && stripos($resp->document, $searchString) !== false) {
                $filteredResults[] = $resp;
            }
        }
        if (!empty($zona)) {
            $filteredResults = array_filter($filteredResults, function ($resp) use ($zona) {
                return $resp->zone == $zona;
            });
        }
        if (!empty($designacao)) {
            $filteredResults = array_filter($filteredResults, function ($resp) use ($designacao) {
                // Considerando que a designação está contida no campo <name> do endpoint
                return stripos($resp->name, $designacao) !== false;
            });
        }

        // Ordena os resultados com base na opção de ordenação
        if ($ordenation == 'asc') {
            usort($filteredResults, function ($a, $b) {
                return strtotime($a->date) - strtotime($b->date);
            });
        } else {
            usort($filteredResults, function ($a, $b) {
                return strtotime($b->date) - strtotime($a->date);
            });
        }

        // Pagina os resultados
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($filteredResults, $perPage * ($currentPage - 1), $perPage);
        $itemsPaginate = new LengthAwarePaginator($currentItems, count($filteredResults), $perPage);

        return $itemsPaginate;
    }

    public function entradaNumDevolucoesClientes($id): ?string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return?type=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        // Verificar se a resposta está vazia ou inválida
        if (!$response_decoded || !isset($response_decoded->customer_return)) {
            return null; // Ou lança uma exceção, dependendo do seu fluxo de tratamento de erros
        }

        // Iterar sobre as linhas da resposta e encontrar o documento da encomenda
        foreach ($response_decoded->customer_return as $item) {
            if ($item->id == $id) {
                return $item->document; // Retorna o documento da encomenda
            }
        }

        // Se a encomenda não for encontrada, retorne null ou lance uma exceção
        return null;
    }

    public function detalhesdevolucoesclientes($id, $perPage): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($response_decoded != null) {
            $currentItems = array_slice($response_decoded->lines, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $response_decoded->lines), $perPage);
        } else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $currentItems), $perPage);
        }

        return $itemsPaginate;
    }

    public function devolclientQtdStock($id): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/products/products?referense=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded->products[0]->stock;
    }

    public function devoluclientconferecod($id): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded;
    }

    public function devolclientguardstock($id): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded;
    }

    //DEVOLUÇÕES MATERIAL DANIFICADO
    public function devolucoesMaterialDanificadoCodBarras($perPage): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return?type=2',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($response_decoded != null) {
            $currentItems = array_slice($response_decoded->customer_return, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $response_decoded->customer_return), $perPage);
        } else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $currentItems), $perPage);
        }

        return $itemsPaginate;
    }

    public function getDevolucoesdanificadoSearch($searchString, $ordenation, $perPage, $zona, $designacao): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return?type=2',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        $filteredResults = [];

        foreach ($response_decoded->customer_return as $resp) {
            if (isset($resp->document) && stripos($resp->document, $searchString) !== false) {
                $filteredResults[] = $resp;
            }
        }
        if (!empty($zona)) {
            $filteredResults = array_filter($filteredResults, function ($resp) use ($zona) {
                return $resp->zone == $zona;
            });
        }
        if (!empty($designacao)) {
            $filteredResults = array_filter($filteredResults, function ($resp) use ($designacao) {
                // Considerando que a designação está contida no campo <name> do endpoint
                return stripos($resp->name, $designacao) !== false;
            });
        }

        // Ordena os resultados com base na opção de ordenação
        if ($ordenation == 'asc') {
            usort($filteredResults, function ($a, $b) {
                return strtotime($a->date) - strtotime($b->date);
            });
        } else {
            usort($filteredResults, function ($a, $b) {
                return strtotime($b->date) - strtotime($a->date);
            });
        }

        // Pagina os resultados
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($filteredResults, $perPage * ($currentPage - 1), $perPage);
        $itemsPaginate = new LengthAwarePaginator($currentItems, count($filteredResults), $perPage);

        return $itemsPaginate;
    }

    public function entradaNumDevolucoesDanificado($id): ?string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return?type=2',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        // Verificar se a resposta está vazia ou inválida
        if (!$response_decoded || !isset($response_decoded->customer_return)) {
            return null; // Ou lança uma exceção, dependendo do seu fluxo de tratamento de erros
        }

        // Iterar sobre as linhas da resposta e encontrar o documento da encomenda
        foreach ($response_decoded->customer_return as $item) {
            if ($item->id == $id) {
                return $item->document; // Retorna o documento da encomenda
            }
        }

        // Se a encomenda não for encontrada, retorne null ou lance uma exceção
        return null;
    }

    public function detalhesdevolucoesmaterial($id, $perPage): LengthAwarePaginator
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($response_decoded != null) {
            $currentItems = array_slice($response_decoded->lines, $perPage * ($currentPage - 1), $perPage);

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $response_decoded->lines), $perPage);
        } else {

            $currentItems = [];

            $itemsPaginate = new LengthAwarePaginator($currentItems, count((array) $currentItems), $perPage);
        }

        return $itemsPaginate;
    }

    public function devolmaterialQtdStock($id): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/products/products?referense=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded->products[0]->stock;
    }

    public function devolumaterialconferecod($id): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded;
    }

    public function devolmaterialguardstock($id): object
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/in/customer_return/lines?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded;
    }

    public function stock($id): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/products/products?referense=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);

        return $response_decoded->products[0]->stock;
    }

//Login
    public function selectStock(): object
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://phc.boxpt.com:443/stock/warehouses',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        if (!$response_decoded) {
            return null;
        }
        return $response_decoded;
    }
}
