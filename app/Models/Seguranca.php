<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seguranca extends Model
{
    protected $fillable = [
        'levantamentoRealizados',
        'treinamentosRealizados',
        'laudosVendidos',
        'laudosEmitidos',
        'competencia',
    ];
}
