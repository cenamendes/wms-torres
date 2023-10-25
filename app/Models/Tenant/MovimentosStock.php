<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentosStock extends Model
{
    use HasFactory;

    protected $table = 'movimentos_stock';
    protected $fillable = ['id_movimento','nr_encomenda','cod_barras','reference','qtd','tipo','localizacao'];

    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('id');
        });
    }


}
