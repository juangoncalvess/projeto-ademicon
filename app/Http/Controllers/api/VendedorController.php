<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vendedores;

class VendedorController extends Controller
{

    public function index()
    {
        //return Vendedores::all(); 
        return DB::table('vendedores')->select('*')->where('ativo', '1')->orderBy('nome', 'ASC')->get();
    } 

    public function store(Request $request)
    {
        return Vendedores::create($request->all());
    }

    public function show(string $id)
    {
        return Vendedores::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        return Vendedores::findOrFail($id)->update($request->all());
    } 
}