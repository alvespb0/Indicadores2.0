<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comercial extends Model
{
    protected $fillable = [
        'propostasEnviadas',
        'propostasFechadas',
        'clientesNovos',
        'renovacoes',
        'valorTotal',
        'competencia',
    ];}
