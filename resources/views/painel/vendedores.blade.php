@extends('layouts.main')
@section('title', 'Ademicon')
@section('content')
    <div class="container-principal">
        <p class="container-principal-titulo">Painel > Vendedores > {{ $pagina }}</p> 
        <div class="container-principal-div">
            @if($pagina == "Cadastrar" || $pagina == "Editar")
                <div class="container-painel-div-form">
                    <div class="wid-100pc">
                        <p>Nome: <b>*</b></p>
                        <input type="text" class="input-nome" value="{{ $pagina == 'Editar' ? $resultDB->nome : '' }}">
                    </div>
                    <div class="wid-68pc wid-100pc-990">
                        <p>E-mail: <b>*</b></p>
                        <input type="email" class="input-email" value="{{ $pagina == 'Editar' ? $resultDB->email : '' }}">
                    </div>
                    <div class="wid-30pc wid-100pc-990">
                        <p>Data de nascimento: <b>*</b></p>
                        <input type="date" class="input-data_nascimento" max="{{ Funcao::data_atual() }}" value="{{ $pagina == 'Editar' ? Funcao::data_nascimentoUSA($resultDB->data_nascimento) : '' }}">
                    </div>
                    <div class="wid-100pc">  
                        @if($pagina == "Cadastrar")
                            <a class="button-form button-acao-{{ $pagina }}" id="{{ $pagina }}">Cadastrar</a>
                        @else
                            <a class="button-form button-acao-{{ $pagina }}" id="{{ $pagina }}" id_vendedor="{{ $resultDB->id }}">Salvar</a> 
                        @endif 
                    </div>
                </div>  
            @elseif($pagina == "Listar")
                <a class="bota-de-acao-abaixo-do-form" href="{{ asset('painel/vendedores/cadastrar') }}">Cadastrar vendedor</a>
                <table class="container-principal-div-table">
                    <thead>
                        <tr>
                            <td>Vendedor</td>
                            <td class="display-none-1200">E-mail</td>
                            <td class="wid-data-nasc text-center">Data nasc.</td>
                            <td class="wid-acao text-center">Ação</td>
                        </tr>
                    </thead>
                    <tbody></tbody> 
                </table>
            @else
                <a class="bota-de-acao-abaixo-do-form" href="{{ asset('painel/vendedores/listar') }}">Voltar</a>
                <p class="titulo-nome-vendedor"></p>
                <table class="container-principal-div-table">
                    <thead>
                        <tr>
                            <td>Data</td>
                            <td class="wid-resumo-itens-vendidos text-center">Itens vendidos</td>
                            <td class="wid-resumo-valor-da-venda text-center">Valor da venda</td>
                        </tr>
                    </thead>
                    <tbody></tbody> 
                </table>
            @endif
        </div> 
    </div>
@endsection