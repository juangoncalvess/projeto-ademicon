<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Clientes;

class ClienteController extends Controller
{
    public function index()
    {
        return DB::table('clientes')->select('*')->where('ativo', '1')->orderBy('nome', 'ASC')->get();
    } 

    public function store(Request $request)
    {
        return Clientes::create($request->all());
    }

    public function show(string $id)
    {
        return Clientes::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        return Clientes::findOrFail($id)->update($request->all());
    } 
}
