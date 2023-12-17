<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendas extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'vendas';
    protected $fillable = [
        'id_cliente',
        'id_vendedor',
        'id_forma_de_pagamento',
        'valor_total',
        'data_da_venda',
    ];

}
