@extends('layouts.main')
@section('title', 'Ademicon')
@section('content')
    <div class="container-principal">
        <p class="container-principal-titulo">Painel > Clientes > {{ $pagina }}</p> 
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
                        <p>CPF: <b>*</b></p>
                        <input type="text" class="input-cpf valida-cpf" value="{{ $pagina == 'Editar' ? $resultDB->cpf : '' }}">
                    </div>
                    <div class="wid-20pc wid-100pc-990">
                        <p>CEP: <b>*</b></p>
                        <input type="text" class="input-cep valida-cep" value="{{ $pagina == 'Editar' ? $resultDB->cep : '' }}">
                    </div>
                    <div class="wid-56pc wid-100pc-990">
                        <p>Endereço: <b>*</b></p>
                        <input type="text" class="input-logradouro" value="{{ $pagina == 'Editar' ? $resultDB->logradouro : '' }}">
                    </div>
                    <div class="wid-20pc wid-100pc-990">
                        <p>Complemento: <b>*</b></p>
                        <input type="text" class="input-complemento" value="{{ $pagina == 'Editar' ? $resultDB->complemento : '' }}">
                    </div>
                    <div class="wid-36pc wid-100pc-990">
                        <p>Bairro: <b>*</b></p>
                        <select class="input-bairro" value="{{ $pagina == 'Editar' ? $resultDB->bairro : '' }}">
                            <option value="" hidden>Selecione a cidade...</option>
                            @if($pagina == 'Editar')
                                @foreach($bairrosDB as $bairros)
                                    <option value="{{ $bairros->bairro }}" {{ $bairros->bairro == $resultDB->bairro ? 'selected' : '' }}>{{ $bairros->bairro }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="wid-45pc wid-100pc-990">
                        <p>Cidade: <b>*</b></p>
                        <select class="input-localidade" value="{{ $pagina == 'Editar' ? $resultDB->localidade : '' }}">
                            <option value="" hidden>Selecione o estado...</option>
                            @if($pagina == 'Editar')
                                @foreach($cidadesDB as $cidades)
                                    <option value="{{ $cidades->cidade }}" {{ $cidades->cidade == $resultDB->localidade ? 'selected' : '' }}>{{ $cidades->cidade }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div> 
                    <div class="wid-15pc wid-100pc-990">
                        <p>Estado: <b>*</b></p>
                        <select class="input-uf">
                            <option value="" hidden>Selecione</option> 
                            @if($pagina == 'Editar')
                                @foreach($estadosDB as $estados)
                                    <option value="{{ $estados->uf }}" {{ $estados->uf == $resultDB->uf ? 'selected' : '' }}>{{ $estados->uf }}</option>
                                @endforeach
                            @else
                                @foreach($estadosDB as $estados)
                                    <option value="{{ $estados->uf }}">{{ $estados->uf }}</option>
                                @endforeach
                            @endif
                        </select> 
                    </div> 
                    <div class="wid-100pc">  
                        @if($pagina == "Cadastrar")
                            <a class="button-form button-acao-{{ $pagina }}" id="{{ $pagina }}">Cadastrar</a>
                        @else
                            <a class="button-form button-acao-{{ $pagina }}" id="{{ $pagina }}" id_cliente="{{ $resultDB->id }}">Salvar</a> 
                        @endif 
                    </div>
                </div> 
            @elseif($pagina == "Listar")
                <a class="bota-de-acao-abaixo-do-form" href="{{ asset('painel/clientes/cadastrar') }}">Cadastrar cliente</a>
                <table class="container-principal-div-table">
                    <thead>
                        <tr>
                            <td>Nome</td>
                            <td class="display-none-990">E-mail</td>
                            <td class="wid-cpf text-center display-none-990">CPF</td>
                            <td class="display-none-1200">Endereço</td>
                            <td class="wid-acao text-center">Ação</td>
                        </tr>
                    </thead>
                    <tbody></tbody> 
                </table>
            @else
                <a class="bota-de-acao-abaixo-do-form" href="{{ asset('painel/clientes/listar') }}">Voltar</a>
                <p class="titulo-nome-vendedor"></p>
                <table class="container-principal-div-table">
                    <thead>
                        <tr>
                            <td>Últimas compras</td>
                            <td class="display-none-990">Vendedor</td>
                            <td class="wid-resumo-itens-vendidos text-center display-none-990">Quantidade de itens</td>
                            <td class="wid-resumo-valor-da-venda text-center">Valor da compra</td>
                        </tr>
                    </thead>
                    <tbody></tbody> 
                </table>
            @endif              
        </div>
    </div>
@endsection