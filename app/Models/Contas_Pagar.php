<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contas_Pagar extends Model
{
    use HasFactory;
    protected $table = 'contas_pagar_diario';

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
