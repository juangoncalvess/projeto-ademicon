<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vendas;
use App\Models\Vendas_itens;

class VendaController extends Controller
{
    public function index()
    {
        return DB::table('vendas')->join('clientes', 'clientes.id', '=', 'vendas.id_cliente')->join('vendedores', 'vendedores.id', '=', 'vendas.id_vendedor')->join('formas_de_pagamentos', 'formas_de_pagamentos.id', '=', 'vendas.id_forma_de_pagamento')->select('vendas.data_da_venda', 'clientes.nome as nome_cliente', 'vendedores.nome as nome_vendedor', 'formas_de_pagamentos.nome as forma_de_pagamento', 'vendas.valor_total', 'vendas.id')->orderBy('vendas.data_da_venda', 'DESC')->get();
    } 

    public function store(Request $request)
    {
        return Vendas::create($request->all());
    }

    public function show(string $id)
    {
        return Vendas::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        return Vendas::findOrFail($id)->update($request->all());
    } 

    public function destroy(string $id)
    {
        return Vendas::findOrFail($id)->delete();    
    }
} 
