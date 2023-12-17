<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produtos;

class ProdutoController extends Controller
{

    public function index()
    {
        //return Produtos::all(); 
        return DB::table('produtos')->select('*')->orderBy('nome', 'ASC')->get();
    } 
 
    public function store(Request $request)
    {
        return Produtos::create($request->all());
    }

    public function show(string $id)
    {
        return Produtos::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        return Produtos::findOrFail($id)->update($request->all());
    } 

    public function destroy(string $id)
    {
        return Produtos::findOrFail($id)->delete();     
    }
}
