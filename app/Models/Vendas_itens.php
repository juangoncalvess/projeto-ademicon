<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendas_itens extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $table = 'vendas_itens';
    protected $fillable = [
        'id_venda',
        'id_item',
        'item',
        'valor',
    ];
 
}
