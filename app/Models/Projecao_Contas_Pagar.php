<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projecao_Contas_Pagar extends Model
{
    protected $table = 'projecao_contas_pagar';

    protected $fillable = [
        'uuid',
        'descricao',
        'data_vencimento',
        'status',
        'valor',
        'fornecedor_uuid',
        'fornecedor_nome',
        'data_competencia'
    ];

}
