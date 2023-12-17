<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Resumo_das_vendasController extends Controller
{
    public function index()
    {
        $vendas = DB::table('vendas')->join('vendedores', 'vendedores.id', '=', 'vendas.id_vendedor')->join('clientes', 'clientes.id', '=', 'vendas.id_cliente')->select('vendas.id', 'clientes.nome as cliente_nome', 'vendedores.nome as vendedor_nome', 'vendas.data_da_venda', 'vendas.valor_total')->orderBy('vendas.data_da_venda', 'DESC')->get();  
        $objetoJson = array();
        foreach($vendas as $result){            
            $itens_array = array();
            $vendas_unidade = array();
            $vendas_total = array();    
            $vendas_itens = DB::table('vendas_itens')->select('item', 'valor')->where('id_venda', $result->id)->get();
            foreach($vendas_itens as $itens){
                $vendas_unidade[] = $itens->item;
                $vendas_total[] = $itens->valor;
                $itens_array[] = array(
                    "item" => $itens->item, 
                    "valor" => $itens->valor
                );
            }
            $objetoJson[] = array(
                "venda_id" => $result->id,
                "cliente_nome" => $result->cliente_nome,
                "vendedor_nome" => $result->vendedor_nome,
                "data_da_venda" => $result->data_da_venda,
                "quantidade_de_itens" => count($vendas_unidade),
                "valor_total" => $result->valor_total,
                "itens" => $itens_array,
            );
        } 
        return json_encode($objetoJson, JSON_PRETTY_PRINT);
    }   
}
