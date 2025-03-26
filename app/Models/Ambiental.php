<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ambiental extends Model
{
    protected $fillable = [
        'orcamentosRealizados',
        'orcamentosAprovados',
        'clientesNovos',
        'competencia'
    ];
}
