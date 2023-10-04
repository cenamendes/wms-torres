<?php

namespace App\Repositories\Tenant\Localizacoes;


use App\Models\Tenant\Encomendas;
use App\Models\Tenant\Localizacoes;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\Localizacoes\LocalizacoesInterface;
use App\Http\Requests\Tenant\Localizacoes\LocalizacoesFormRequest;


class LocalizacoesRepository implements LocalizacoesInterface
{
    
    public function getLocalizacoes($perPage): LengthAwarePaginator
    {
        $types = Localizacoes::paginate($perPage);

        return $types;
    }

    public function getLocalizacoesSearch($searchString,$perPage): LengthAwarePaginator
    {
        $types = Localizacoes::where('cod_barras', 'like', '%' . $searchString . '%')->paginate($perPage);
        return $types;
    }

    public function deleteLocation($id)
    {
        $delete = Localizacoes::where('id',$id)->delete();
        return $delete;
    }

    public function add(LocalizacoesFormRequest $request)
    {
        $add = Localizacoes::create([
            "cod_barras" => $request->cod_barras,
            "descricao" => $request->descricao,
            "abreviatura" => $request->abreviatura
        ]);

        return $add;
    }

    public function updateLocation(LocalizacoesFormRequest $request)
    {
       $recebido = $request->all();

       $update = Localizacoes::where('id',$recebido["location_id"])->update([
        "cod_barras" => $recebido["cod_barras"],
        "descricao" => $recebido["descricao"],
        "abreviatura" => $recebido["abreviatura"]
       ]);

       return $update;

    }
   

}

