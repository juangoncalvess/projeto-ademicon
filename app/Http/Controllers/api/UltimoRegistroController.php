<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UltimoRegistroController extends Controller
{
    public function index()
    {
        return DB::table('vendas')->select('id')->orderBy('id', 'DESC')->first();
    } 
}
