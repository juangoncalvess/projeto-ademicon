@extends('layouts.main')
@section('title', 'Ademicon')
@section('content') 
    <div class="container-principal">
        <p class="container-principal-titulo">Painel > Produtos > {{ $pagina }}</p> 
        <div class="container-principal-div">
            @if($pagina != "Listar")
                <div class="container-painel-div-form">
                    <div class="wid-78pc wid-100pc-990">
                        <p>Nome: <b>*</b></p>
                        <input type="text" class="input-nome" value="{{ $pagina == 'Editar' ? $resultDB->nome : '' }}">
                    </div>
                    <div class="wid-20pc wid-100pc-990">
                        <p>Preço: <b>*</b></p>
                        <input type="email" class="input-preco valida-preco" value="{{ $pagina == 'Editar' ? number_format($resultDB->preco, 2, ',' , '.') : '' }}">
                    </div>
                    <div class="wid-100pc">  
                        @if($pagina == "Cadastrar")
                            <a class="button-form button-acao-{{ $pagina }}" id="{{ $pagina }}">Cadastrar</a>
                        @else
                            <a class="button-form button-acao-{{ $pagina }}" id="{{ $pagina }}" id_produto="{{ $resultDB->id }}">Salvar</a> 
                        @endif 
                    </div>
                </div>  
            @else
                <a class="bota-de-acao-abaixo-do-form" href="{{ asset('painel/produtos/cadastrar') }}">Cadastrar produto</a>
                <table class="container-principal-div-table">
                    <thead>
                        <tr>
                            <td>Nome</td>
                            <td class="text-center">Preço</td>
                            <td class="wid-acao text-center">Ação</td>
                        </tr>
                    </thead>
                    <tbody></tbody> 
                </table>
            @endif
        </div>
    </div>
@endsection