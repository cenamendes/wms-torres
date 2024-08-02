<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisesPicking extends Model
{
    use HasFactory;

    protected $table = 'analises_picking';

    protected $fillable = ['numero_encomenda','document','referencia','descricao','locais_stock','estado','qtd_separada', 'created_at', 'updated_at'];

    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('id');
        });
    }

}
