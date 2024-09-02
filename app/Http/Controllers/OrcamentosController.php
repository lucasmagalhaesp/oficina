<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrcamentosRequest;
use App\Models\Orcamento;
use Illuminate\Http\Request;

class OrcamentosController extends Controller
{
    public function index(Request $request, Orcamento $orcamento)
    {
        $filtros = $request->filtros ?? null;
        $dados = $orcamento->getDados($filtros);
        if (!$dados) response()->json("Erro ao buscar os dados dos orçamentos", 500);
        
        return response()->json($dados, 200);
    }

    public function store(OrcamentosRequest $request, Orcamento $orcamento)
    {
        $dados = $request->dados;
        if (is_null($dados)) return response()->json("Dados não enviados", 500);
        $retorno = $orcamento->gravar($dados);
        
        if (!$retorno) response()->json("Erro ao gravar orçamento", 500);
    
        return response()->json(true, 200);
    }

    public function edit($id)
    {
        if (is_null($id)) return response()->json("Código do orçamento não informado", 500);

        $dados = (new Orcamento)->getOrcamento($id);
        if (!$dados) return response()->json("Erro ao editar orçamento", 500);

        return response()->json($dados, 200);
    }

    public function destroy($id)
    {
        if (is_null($id)) return response()->json("Código do orçamento não informado", 500);

        $retornoExc = (new Orcamento)->excluir($id);
        if (!$retornoExc) return response()->json("Erro ao excluir orçamento", 500);

        return response()->json(true, 200);
    }
}
