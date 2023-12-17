<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'clientes';
    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'cep',
        'logradouro',
        'complemento',
        'bairro',
        'localidade',
        'uf',
        'ibge',
        'ddd',
        'ativo',
    ];
}
