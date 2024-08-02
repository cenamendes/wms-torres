<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportadosStock extends Model
{
    use HasFactory;

    protected $table = 'reportados_stock';

    protected $fillable = ['uuid','numero_encomenda','document','referencia','observacao','qtd_correta','status', 'created_at', 'updated_at'];

    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('id');
        });
    }

}
