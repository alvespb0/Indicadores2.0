<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contas_Receber extends Model
{
    use HasFactory;
    protected $table = 'contas_receber_diario';

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
