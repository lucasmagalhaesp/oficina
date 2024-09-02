<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrcamentosRequest;
use App\Models\Orcamento;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrcamentosController extends Controller
{
    /**Função para listar os orçamentos
     * @author Lucas Magalhães
     * @param object $request - Objeto que fornecerá os filtros para serem processados
     * @param object $orcamentos - Model Orcamento que chamará a função de listagem
     * @return string JSON - Orçamentos filtrados
     */
    public function index(Request $request, Orcamento $orcamento) : JsonResponse
    {
        $filtros = $request->filtros ?? null;
        $dados = $orcamento->getDados($filtros);
        if (!$dados) response()->json("Erro ao buscar os dados dos orçamentos", 500);
        
        return response()->json($dados, 200);
    }

    /**Função para cadastrar um orçamento
     * @author Lucas Magalhães
     * @param object $request - Objeto que fornecerá os dados do orçamento que serão gravados
     * @param object $orcamentos - Model Orcamento que chamará a função de cadastro
     * @return string JSON - Confirmação do cadastro ou mensagem de erro
     */
    public function store(OrcamentosRequest $request, Orcamento $orcamento) : JsonResponse
    {
        $dados = $request->dados;
        if (is_null($dados)) return response()->json("Dados não enviados", 500);
        $retorno = $orcamento->gravar($dados);
        
        if (!$retorno) response()->json("Erro ao gravar orçamento", 500);
    
        return response()->json(true, 200);
    }

    /**Função para buscar os dados um orçamento que será editado
     * @author Lucas Magalhães
     * @param int $id - Código do orçamento
     * @return string JSON - Dados do orçamento ou mensagem de erro
     */
    public function edit($id) : JsonResponse
    {
        if (is_null($id)) return response()->json("Código do orçamento não informado", 500);

        $dados = (new Orcamento)->getOrcamento($id);
        if (!$dados) return response()->json("Erro ao editar orçamento", 500);

        return response()->json($dados, 200);
    }

    /**Função para excluir um orçamento
     * @author Lucas Magalhães
     * @param int $id - Código do orçamento
     * @return string JSON - Confirmação da exclusão ou mensagem de erro
     */
    public function destroy($id) : JsonResponse
    {
        if (is_null($id)) return response()->json("Código do orçamento não informado", 500);

        $retornoExc = (new Orcamento)->excluir($id);
        if (!$retornoExc) return response()->json("Erro ao excluir orçamento", 500);

        return response()->json(true, 200);
    }
}
