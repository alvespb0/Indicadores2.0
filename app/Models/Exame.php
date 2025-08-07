<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exame extends Model
{
    protected $fillable = [
        'clinicos',
        'audiometrias',
        'laboratoriais',
        'raiox',
        'complementares',
        'outros_exames',
        'competencia',
    ];

}
