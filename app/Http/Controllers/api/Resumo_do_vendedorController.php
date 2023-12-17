<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Resumo_do_vendedorController extends Controller
{
    public function show(string $id)
    {

        $vendedor = DB::table('vendedores')->select('id', 'nome')->where('id', $id)->first();
        $vendedor_id = $vendedor->id; 
        $vendedor_nome = $vendedor->nome;

        $vendas = DB::table('vendas')->select('id', 'valor_total', 'data_da_venda')->where('id_vendedor', $id)->orderBy('data_da_venda', 'DESC')->get();

        $vendedor_quantidade_de_vendas = array();
        $vendedor_total_de_vendas = array();        
        $vendas_array = array();
        
        foreach($vendas as $result){
            $vendedor_quantidade_de_vendas[] = $result->id;
            $vendedor_total_de_vendas[] = $result->valor_total;
            
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
 
            $vendas_array[] = array(
                "id_venda" => $result->id, 
                "data" => $result->data_da_venda,  
                "quantidade_de_itens" => count($vendas_unidade), 
                "valor_da_venda" => number_format(array_sum($vendas_total), 2, '.', ''), 
                "itens" => $itens_array
            );
        }

        $objetoJson = array(
            "vendedor_id" => $vendedor_id,
            "vendedor_nome" => $vendedor_nome,
            "quantidade_de_vendas" => count($vendedor_quantidade_de_vendas),
            "total_de_vendas" => number_format(array_sum($vendedor_total_de_vendas), 2, '.', ''),
            "vendas" => $vendas_array,
        );

        return json_encode($objetoJson, JSON_PRETTY_PRINT);
    }   
}
