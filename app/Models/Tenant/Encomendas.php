<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomendas extends Model
{
    use HasFactory;

    protected $table = 'encomendas';
    protected $fillable = ['numero_encomenda','nome_fornecedor','nif_fornecedor','data_documento','linhas_encomenda','imagem','preco_final'];

    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('numero_encomenda');
        });
    }


}
