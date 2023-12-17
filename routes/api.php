<?php

Route::apiResource('vendedor', 'api\VendedorController'); 
Route::apiResource('cliente', 'api\ClienteController'); 
Route::apiResource('produto', 'api\ProdutoController');
Route::apiResource('venda', 'api\VendaController');
Route::apiResource('venda-itens', 'api\Venda_itensController');
Route::apiResource('get-ultimo-registro-db', 'api\UltimoRegistroController'); 
Route::apiResource('resumo-do-vendedor', 'api\Resumo_do_vendedorController'); 
Route::apiResource('resumo-do-cliente', 'api\Resumo_do_clienteController'); 
Route::apiResource('resumo-das-vendas', 'api\Resumo_das_vendasController'); 
Route::apiResource('mensuracao-mensal', 'api\mensuracao_mensalController'); 

//Route::apiResource('vendedor', 'api\VendedorController')->middleware('auth:sanctum'); 
//Route::apiResource('cliente', 'api\VendedorController')->middleware('auth:sanctum'); 
//Route::apiResource('produto', 'api\ProdutoController')->middleware('auth:sanctum'); 
//Route::apiResource('venda', 'api\VendaController')->middleware('auth:sanctum'); 
//Route::apiResource('venda', 'api\Venda_itensController')->middleware('auth:sanctum'); 
//Route::apiResource('get-ultimo-registro-db', 'api\UltimoRegistroController')->middleware('auth:sanctum'); 
//Route::apiResource('resumo-do-vendedor', 'api\Resumo_do_vendedorController')->middleware('auth:sanctum');   
//Route::apiResource('resumo-do-cliente', 'api\Resumo_do_clienteController')->middleware('auth:sanctum');   
//Route::apiResource('resumo-das-vendas', 'api\Resumo_das_vendasController')->middleware('auth:sanctum');   
//Route::apiResource('mensuracao-mensal', 'api\mensuracao_mensalController')->middleware('auth:sanctum');   