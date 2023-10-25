<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentosStockTemporary extends Model
{
    use HasFactory;

    protected $table = 'movimentos_stock_temporaria';
    protected $fillable = ['id_movimento','nr_encomenda','cod_barras','reference','qtd_inicial','qtd_separada','qtd_separada_recente','tipo','localizacao','concluded_movement'];

    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('id');
        });
    }


}
