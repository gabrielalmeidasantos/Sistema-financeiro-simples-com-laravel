<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transacao extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    protected $fillable = [
        'valor',
        'data',
        'tipo_transacao',
        'descricao',
        'categoria',
        'id_user'
    ];
}
