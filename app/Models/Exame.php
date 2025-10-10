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
        'eeg',
        'ecg',
        'acuidade',
        'espirometria',
        'outros_exames',
        'competencia',
    ];

}
