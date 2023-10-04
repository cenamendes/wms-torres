<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localizacoes extends Model
{
    use HasFactory;

    protected $table = 'localizacoes';
    protected $fillable = ['cod_barras','descricao','abreviatura'];

    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('id');
        });
    }

    public function getRouteKeyName()
    {
        return 'id';
    }


}
