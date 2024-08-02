<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentosSaidas extends Model
{
    use HasFactory;

    protected $table = 'movimentos_saidas';
    protected $fillable = ['numero_encomenda','id_line','document','referencia','barcode','descricao','locais_stock','estado','qtd_separada','internal_notes','stock','warehouse', 'created_at', 'updated_at'];

    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('id');
        });
    }


}
