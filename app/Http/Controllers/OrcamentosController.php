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
        $dados = $orcamento->getOrcamentos($filtros);
        if (!$dados) response()->json("Erro ao buscar os dados dos orçamentos", 500);
        
        return response()->json($dados, 200);
    }

    public function create()
    {
        
    }

    public function store(OrcamentosRequest $request, Orcamento $orcamento)
    {
        $dados = $request->dados;
        if (is_null($dados)) return response()->json("Dados não enviados", 500);
        $retorno = $orcamento->gravarOrcamento($dados);
        
        if (!$retorno) response()->json("Erro ao gravar orçamento", 500);
    
        return response()->json(true, 200);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
