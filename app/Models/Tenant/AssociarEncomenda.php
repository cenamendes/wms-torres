<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociarEncomenda extends Model
{
    use HasFactory;

    protected $table = 'associar_encomenda';

    protected $fillable = ['numero_encomenda', 'name', 'username', 'type_user','user_id','created_at', 'updated_at'];

    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('id');
        });
    }

}
