<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projecao_Contas_Receber extends Model
{
    protected $table = 'projecao_contas_receber';

    protected $fillable = [
        'uuid',
        'descricao',
        'data_vencimento',
        'status',
        'valor',
        'cliente_uuid',
        'cliente_nome',
        'data_competencia'
    ];

}
