<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class mensuracao_mensalController extends Controller
{
    public function show(string $data_selecionada)
    {
        $pagamentoDB = DB::table('vendas')->join('formas_de_pagamentos', 'formas_de_pagamentos.id', '=', 'vendas.id_forma_de_pagamento')->select('vendas.id_forma_de_pagamento', 'formas_de_pagamentos.nome')->where('vendas.data_da_venda', 'like', '%'.$data_selecionada.'%')->groupBy('vendas.id_forma_de_pagamento')->get(); 
        $valoresDB = DB::table('vendas')->selectRaw('count(id) as quantidade_total, sum(valor_total) as valor_total')->where('data_da_venda', 'like', '%'.$data_selecionada.'%')->first(); 
        $pagamento_array = array();
        $objetoJson = array();
        foreach($pagamentoDB as $pagamento){
            $valor_total_por_formas_de_pagamento = array();
            $quantidade_por_formas_de_pagamento = array();
            $vendas_por_formas_de_pagamentoDB = DB::table('vendas')->select('*')->where('id_forma_de_pagamento', $pagamento->id_forma_de_pagamento)->where('data_da_venda', 'like', '%'.$data_selecionada.'%')->orderBy('data_da_venda', 'DESC')->get();  
            foreach($vendas_por_formas_de_pagamentoDB as $vendas_por_formas_de_pagamento){
                $valor_total_por_formas_de_pagamento[] = $vendas_por_formas_de_pagamento->valor_total;
                $quantidade_por_formas_de_pagamento[] = $vendas_por_formas_de_pagamento->id;
            } 
            $pagamento_array[] = array(
                "formas_de_pagamento_tipo" => $pagamento->nome,
                "valor_total_por_formas_de_pagamento" => number_format(array_sum($valor_total_por_formas_de_pagamento), 2, '.', ''),
                "quantidade_por_formas_de_pagamento" => count($quantidade_por_formas_de_pagamento),
            );
        }
        $objetoJson = array(
            "data_selecionada" => $data_selecionada,
            "valor_total_de_todas_as_vendas" => $valoresDB->valor_total,
            "quantidade_total_de_todas_as_vendas" => $valoresDB->quantidade_total,
            "formas_de_pagamento" => $pagamento_array,
        );
        return json_encode($objetoJson, JSON_PRETTY_PRINT);
    }   
}
