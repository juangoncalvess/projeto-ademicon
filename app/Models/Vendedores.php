<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedores extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'vendedores';
    protected $fillable = [
        'nome',
        'email',
        'data_nascimento',
        'ativo',
    ];
}
