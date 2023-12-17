<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vendas_itens;

class Venda_itensController extends Controller
{
    public function store(Request $request)
    {
        return Vendas_itens::create($request->all());
    }
}
