<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Helpers\Funcao;

class MainController extends Controller
{
    
    /*
    public function auth (Request $request){ 
        $user = auth()->user();
        $user->tokens()->delete();
        $token = $user->createToken($user['email'])->plainTextToken;
        Cookie::queue('token-api-auth', $token);
        //$token = $request->cookie('token-api-auth');
        //$url = $request->root();
        return redirect("/dashboard");    
    }
    */

    public function index(){
        return redirect("/painel");
    }

    public function painel_index(){
        $datas_vendas = DB::table('vendas')->select('data_da_venda')->groupBy('data_da_venda')->orderBy('data_da_venda', 'DESC')->get();
        $datas_unicas = array();
        foreach($datas_vendas as $datas){
            $datas_unicas[] = Funcao::datas_remove_dia($datas->data_da_venda);
        }
        $datas_vendas = array_unique($datas_unicas);
        return view('painel.index', ['datas_vendas' => $datas_vendas]); 
    }

    public function painel_vendedores($pagina, $id = null){
        switch($pagina){
            case "cadastrar":
                return view('painel.vendedores', ['pagina' => 'Cadastrar']); 
            break;
            case "editar":
                $resultDB = DB::table('vendedores')->select('*')->where('id', $id)->first();
                return view('painel.vendedores', ['pagina' => 'Editar', 'resultDB' => $resultDB]); 
            break; 
            case "listar": 
                return view('painel.vendedores', ['pagina' => 'Listar']);  
            break;
            case "resumo":               
                return view('painel.vendedores', ['pagina' => 'Resumo']);  
            break;
        }
    }

    public function painel_clientes($pagina, $id = null){
        $estadosDB = DB::table('cepbr_estado')->select('uf')->orderBy('uf', 'ASC')->get();
        switch($pagina){
            case "cadastrar":
                return view('painel.clientes', ['pagina' => 'Cadastrar', 'estadosDB' => $estadosDB]); 
            break;
            case "editar":
                $resultDB = DB::table('clientes')->select('*')->where('id', $id)->first();
                $cidadesDB = DB::table('cepbr_cidade')->select('*')->where('uf', $resultDB->uf)->orderBy('cidade', 'ASC')->get();
                $bairrosDB = DB::table('cepbr_cidade')->join('cepbr_bairro', 'cepbr_bairro.id_cidade', '=', 'cepbr_cidade.id_cidade')->select('cepbr_bairro.bairro')->where('cepbr_cidade.cidade', $resultDB->localidade)->orderBy('cepbr_bairro.bairro', 'ASC')->get();               
                return view('painel.clientes', ['pagina' => 'Editar', 'resultDB' => $resultDB, 'estadosDB' => $estadosDB, 'cidadesDB' => $cidadesDB, 'bairrosDB' => $bairrosDB]); 
            break;
            case "listar":
                return view('painel.clientes', ['pagina' => 'Listar']); 
            break;
            case "resumo":
                return view('painel.clientes', ['pagina' => 'Resumo']);  
            break;
        }
    }

    public function painel_produtos($pagina, $id = null){
        switch($pagina){
            case "cadastrar":
                return view('painel.produtos', ['pagina' => 'Cadastrar']); 
            break; 
            case "editar":
                $resultDB = DB::table('produtos')->select('*')->where('id', $id)->first();
                return view('painel.produtos', ['pagina' => 'Editar', 'resultDB' => $resultDB]); 
            break;
            case "listar":
                return view('painel.produtos', ['pagina' => 'Listar']); 
            break;
        }
    }

    public function painel_vendas($pagina, $id = null){
        $clientesDB = DB::table('clientes')->select('*')->where('ativo', '1')->orderBy('nome', 'ASC')->get(); 
        $vendedoresDB = DB::table('vendedores')->select('*')->where('ativo', '1')->orderBy('nome', 'ASC')->get();
        $produtosDB = DB::table('produtos')->select('*')->orderBy('nome', 'ASC')->get();
        $pagamentoDB = DB::table('formas_de_pagamentos')->select('*')->orderBy('nome', 'ASC')->get();
        switch($pagina){
            case "cadastrar":
                $resultDB = DB::table('produtos')->select('*')->orderBy('nome', 'ASC')->get(); 
                return view('painel.vendas', ['pagina' => 'Cadastrar', 'resultDB' => $resultDB, 'clientesDB' => $clientesDB, 'vendedoresDB' => $vendedoresDB, 'produtosDB' => $produtosDB, 'pagamentoDB' => $pagamentoDB]); 
            break; 
            case "editar":
                $resultDB = DB::table('vendas')->select('*')->where('id', $id)->first(); 
                $vendas_itensDB = DB::table('vendas_itens')->select('*')->where('id_venda', $id)->get(); 
                $vendas_itens_array = [];
                foreach($vendas_itensDB as $vendas_itens){
                    $vendas_itens_array[] = $vendas_itens->id_item;
                }
                return view('painel.vendas', ['pagina' => 'Editar', 'resultDB' => $resultDB, 'clientesDB' => $clientesDB, 'vendedoresDB' => $vendedoresDB, 'produtosDB' => $produtosDB, 'pagamentoDB' => $pagamentoDB, 'vendas_itensDB' => $vendas_itensDB, 'vendas_itens_array' => $vendas_itens_array]); 
            break;
            case "listar":
                return view('painel.vendas', ['pagina' => 'Listar']); 
            break;
        }
    }

    public function ajax ($acao, $value){
        switch($acao){       
            case "cepbr_bairro":
                $json['result'] = DB::table('cepbr_cidade')->join('cepbr_bairro', 'cepbr_bairro.id_cidade', '=', 'cepbr_cidade.id_cidade')->select('cepbr_bairro.bairro')->where('cepbr_cidade.cidade', $value)->orderBy('cepbr_bairro.bairro', 'ASC')->get();
            break;
            case "cepbr_cidade":
                $json['result'] = DB::table('cepbr_cidade')->join('cepbr_estado', 'cepbr_estado.uf', '=', 'cepbr_cidade.uf')->select('cepbr_cidade.cidade', 'cepbr_estado.uf')->where('cepbr_estado.uf', $value)->orderBy('cepbr_cidade.cidade', 'ASC')->get();
            break;
                    
            case "cepbr_estado":
                $json['result'] = DB::table('cepbr_estado')->select('*')->orderBy('uf', 'ASC')->get();
            break;
        }  
        echo json_encode($json);  
        return; 
    } 
}