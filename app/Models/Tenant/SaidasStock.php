<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaidasStock extends Model
{
    use HasFactory;

    protected $table = 'saidas';
    protected $fillable = ['numero_encomenda','document','nome','fonte', 'descricao', 'user_name', 'user_id', 'created_at', 'updated_at'];

    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('id');
        });
    }


}
