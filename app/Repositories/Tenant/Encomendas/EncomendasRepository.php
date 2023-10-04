<?php

namespace App\Repositories\Tenant\Encomendas;

use App\Models\Tenant\Encomendas;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;


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

    public function getLocalizacoes($perPage): LengthAwarePaginator
    {
        $types = Encomendas::paginate($perPage);

        return $types;
    }

   

}

