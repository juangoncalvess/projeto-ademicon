<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'produtos';
    protected $fillable = [
        'nome',
        'preco',
    ];

}
