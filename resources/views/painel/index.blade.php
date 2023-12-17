@extends('layouts.main')
@section('title', 'Ademicon')
@section('content')
    <div class="container-principal">
        <p class="container-principal-titulo">Painel > Dashboard</p> 
        <div class="container-principal-div">
            <p class="titulo-nome-vendedor">Registro de todas as vendas</p>
            <table class="container-principal-div-table">
                <thead>
                    <tr>
                        <td>Data</td>
                        <td>Cliente</td>
                        <td class="display-none-1200">Vendedor</td>
                        <td class="wid-resumo-valor-da-venda text-center display-none-1300">Quantidade de itens</td>
                        <td class="wid-resumo-valor-da-venda text-center">Valor da venda</td>
                    </tr>
                </thead>
                <tbody class="registro-tbody"></tbody> 
            </table>
            <div class="container-meses-dashboard display-none-990">               
                @foreach($datas_vendas as $datas_venda)
                    <a class="mensuracao-mensal {{ $loop->index == 0 ? 'mensuracao-mensal-ativa' : '' }}" id="{{ $datas_venda }}">{{ Funcao::datas_dashboard('BR', $datas_venda) }}</a>
                @endforeach
            </div>
            <div class="container-tabela-mensuracao-mensal display-none-990"></div>
        </div> 
    </div>
@endsection