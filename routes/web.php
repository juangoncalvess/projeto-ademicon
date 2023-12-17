<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

/* 
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index']);
Route::get('/painel', [MainController::class, 'painel_index'])->middleware('auth');
Route::get('/painel/vendedores/{pagina}/{id?}', [MainController::class, 'painel_vendedores'])->middleware('auth');
Route::get('/painel/clientes/{pagina}/{id?}', [MainController::class, 'painel_clientes'])->middleware('auth');
Route::get('/painel/produtos/{pagina}/{id?}', [MainController::class, 'painel_produtos'])->middleware('auth');
Route::get('/painel/vendas/{pagina}/{id?}', [MainController::class, 'painel_vendas'])->middleware('auth');

Route::get('/painel/ajax/{acao}/{value}', [MainController::class, 'ajax'])->middleware('auth');

//Route::get('/auth', [MainController::class, 'auth'])->middleware('auth');