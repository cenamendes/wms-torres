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

        $getOrdens = Localizacoes::all();

        if(!isset($getOrdens->sortBy('ordem')->last()->ordem)){
            $new_number = 1;
        }
        else {
            $last_number = $getOrdens->sortBy('ordem')->last()->ordem;
            $new_number = $last_number + 1;
        }

        if(!isset($request->local_stock))
        {
             $estado = "0";
        }
        else
        {
            
             if($request->local_stock == "off")
             {
                 $estado = "0";
             }
             else 
             {
                 $estado = "1";
             }
         
        }
        

        $add = Localizacoes::create([
            "cod_barras" => $request->cod_barras,
            "descricao" => $request->descricao,
            "abreviatura" => $request->abreviatura,
            "ordem" => $new_number,
            "local_stock" => $estado
        ]);

        return $add;
    }

    public function updateLocation(LocalizacoesFormRequest $request)
    {
       $recebido = $request->all();



       if(!isset($recebido["local_stock"]))
       {
            $estado = "0";
       }
       else
       {
            if($recebido["local_stock"] == "off")
            {
                $estado = "0";
            }
            else 
            {
                $estado = "1";
            }
        
       }

       $update = Localizacoes::where('id',$recebido["location_id"])->update([
        "cod_barras" => $recebido["cod_barras"],
        "descricao" => $recebido["descricao"],
        "abreviatura" => $recebido["abreviatura"],
        "local_stock" => $estado
       ]);

       return $update;

    }
   

}

