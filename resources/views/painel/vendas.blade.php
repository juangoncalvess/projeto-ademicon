@extends('layouts.main')
@section('title', 'Ademicon')
@section('content') 
    <div class="container-principal">
        <p class="container-principal-titulo">Painel > Vendas > {{ $pagina }}</p> 
        <div class="container-principal-div">
            @if($pagina != "Listar")
                <div class="container-painel-div-form">
                    <div class="wid-100pc">
                        <p>Cliente: <b>*</b></p>
                        <select class="input-id_cliente">
                            <option value="" hidden>Selecione</option> 
                            @if($pagina == 'Editar')
                                @foreach($clientesDB as $clientes)
                                    <option value="{{ $clientes->id }}" {{ $clientes->id == $resultDB->id_cliente ? 'selected' : '' }}>{{ $clientes->nome }}</option>
                                @endforeach
                            @else 
                                @foreach($clientesDB as $clientes)
                                    <option value="{{ $clientes->id }}">{{ $clientes->nome }}</option>
                                @endforeach
                            @endif
                        </select> 
                    </div>
                    <div class="wid-56pc wid-100pc-990">
                        <p>Vendedor: <b>*</b></p>
                        <select class="input-id_vendedor">
                            <option value="" hidden>Selecione</option> 
                            @if($pagina == 'Editar')
                                @foreach($vendedoresDB as $vendedores)
                                    <option value="{{ $vendedores->id }}" {{ $vendedores->id == $resultDB->id_vendedor ? 'selected' : '' }}>{{ $vendedores->nome }}</option>
                                @endforeach
                            @else
                                @foreach($vendedoresDB as $vendedores) 
                                    <option value="{{ $vendedores->id }}">{{ $vendedores->nome }}</option>
                                @endforeach
                            @endif
                        </select> 
                    </div>
                    <div class="wid-20pc wid-100pc-990">
                        <p>Forma de pagamento: <b>*</b></p>
                        <select class="input-id_forma_de_pagamento">
                            <option value="" hidden>Selecione</option> 
                            @if($pagina == 'Editar')
                                @foreach($pagamentoDB as $pagamento)
                                    <option value="{{ $pagamento->id }}" {{ $pagamento->id == $resultDB->id_forma_de_pagamento ? 'selected' : '' }}>{{ $pagamento->nome }}</option>
                                @endforeach
                            @else
                                @foreach($pagamentoDB as $pagamento) 
                                    <option value="{{ $pagamento->id }}">{{ $pagamento->nome }}</option>
                                @endforeach
                            @endif
                        </select> 
                    </div>
                    <div class="wid-20pc wid-100pc-990">
                        <p>Data da venda: <b>*</b></p>
                        <input type="date" class="input-data_da_venda" max="{{ Funcao::data_atual() }}" value="{{ $pagina == 'Editar' ? Funcao::data_nascimentoUSA($resultDB->data_da_venda) : '' }}">
                    </div> 
                    <div class="wid-100pc">
                        <p>Produtos: <b>*</b></p>
                        @foreach($produtosDB as $produtos)
                            <div class="wid-100pc">
                                <label class="produtos-checkbox" id="{{ $produtos->id }}">
                                    @if($pagina == 'Editar')
                                        <input type="checkbox" class="input-checkbox checkbox-{{ $produtos->id }}" id="{{ $produtos->id }}" nome="{{ $produtos->nome }}" valor="{{ $produtos->preco }}" {{ array_search($produtos->id, $vendas_itens_array) == "" ? '' : Funcao::verifica_checkbox($produtos->id, $vendas_itensDB) }}>
                                    @else
                                        <input type="checkbox" class="input-checkbox checkbox-{{ $produtos->id }}" id="{{ $produtos->id }}" nome="{{ $produtos->nome }}" valor="{{ $produtos->preco }}">
                                    @endif
                                    <span>{{ $produtos->nome }} | R$ {{ number_format($produtos->preco, 2, ',' , '.') }}</span>
                                </label>
                            </div> 
                        @endforeach
                    </div> 
                    <div class="wid-100pc">  
                        @if($pagina == "Cadastrar")
                            <a class="button-form button-acao-{{ $pagina }}" id="{{ $pagina }}">Cadastrar</a>
                        @else
                            <a class="button-form button-acao-{{ $pagina }}" id="{{ $pagina }}" id_venda="{{ $resultDB->id }}">Salvar</a> 
                        @endif 
                    </div>
                </div>  
            @else
                <a class="bota-de-acao-abaixo-do-form" href="{{ asset('painel/vendas/cadastrar') }}">Cadastrar venda</a>
                <table class="container-principal-div-table">
                    <thead>
                        <tr>
                            <td>Data</td>
                            <td>Cliente</td>
                            <td class="display-none-990">Vendedor</td>
                            <td>Total</td>
                            <td class="wid-acao text-center display-none-990">Ação</td>
                        </tr>
                    </thead>
                    <tbody></tbody> 
                </table>
            @endif
        </div>
    </div>
@endsection