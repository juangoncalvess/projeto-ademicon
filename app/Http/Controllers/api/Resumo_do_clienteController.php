<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Resumo_do_clienteController extends Controller
{
    public function show(string $id)
    {

        $clientes = DB::table('clientes')->select('id', 'nome', 'email', 'cpf', 'logradouro', 'complemento', 'bairro', 'localidade', 'uf')->where('id', $id)->first();
        $cliente_id = $clientes->id; 
        $cliente_nome = $clientes->nome;
        $cliente_email = $clientes->email;
        $cliente_cpf = $clientes->cpf;
        $cliente_endereco = $clientes->logradouro .', '. $clientes->logradouro .' - '. $clientes->bairro .', '. $clientes->localidade .'/'. $clientes->uf;

        $vendas = DB::table('vendas')->join('vendedores', 'vendedores.id', '=', 'vendas.id_vendedor')->select('vendas.id', 'vendas.data_da_venda', 'vendedores.nome', 'vendas.valor_total')->where('vendas.id_cliente', $cliente_id)->orderBy('vendas.data_da_venda', 'DESC')->get();  
    
        $compras_array = array();
        
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
  
            $compras_array[] = array(
                "id_compra" => $result->id, 
                "data" => $result->data_da_venda,  
                "vendedor" => $result->nome,
                "quantidade_de_itens" => count($vendas_unidade), 
                "valor_da_compra" => $result->valor_total, 
                "itens" => $itens_array
            );
        }  

        $objetoJson = array(
            "cliente_id" => $cliente_id,
            "cliente_nome" => $cliente_nome,
            "cliente_email" => $cliente_email,
            "cliente_cpf" => $cliente_cpf,
            "cliente_endereco" => $cliente_endereco,
            "compras" => $compras_array,
        );

        return json_encode($objetoJson, JSON_PRETTY_PRINT);
    }   
}
