<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orcamento extends Model
{
    use HasFactory, SoftDeletes;

    /** Informa ao Model que a tabela orçamento não possui os campos "created_at" e "updated_at" */
    public $timestamps = false;

    /** Informa ao Model o nome do campo que será utilizado pelo SoftDeletes, ao invés de "deleted_at" */
    const DELETED_AT = "data_hora_exclusao";

    /**Função para pesquisar os orçamentos
     * @author Lucas Magalhães
     * @param array $filtros - Array com os filtros fornecidos para a consulta
     * @return object|bool - Orçamentos filtrados
     */
    public function getDados(array $filtros) : object|bool
    {
        try {
            $orcamentos = $this->where(function ($query) use ($filtros){
                                if (!is_null($filtros)){
                                    if (isset($filtros["dataCriacao"]) && !is_null($filtros["dataCriacao"]) && $filtros["dataCriacao"] != "" && 
                                        isset($filtros["dataCriacao"]["dataInicial"]) && !is_null($filtros["dataCriacao"]["dataInicial"]) && $filtros["dataCriacao"]["dataInicial"] != "" && 
                                        isset($filtros["dataCriacao"]["dataFinal"]) && !is_null($filtros["dataCriacao"]["dataFinal"]) && $filtros["dataCriacao"]["dataFinal"] != ""
                                    ){
                                        $dtCriacaoInicial = $filtros["dataCriacao"]["dataInicial"];
                                        $dtCriacaoFinal = $filtros["dataCriacao"]["dataFinal"];
                                        $query->whereBetween("data_hora_criacao", [$dtCriacaoInicial." 00:00:00", $dtCriacaoFinal." 23:59:59"]);
                                    }

                                    if (isset($filtros["cliente"]) && $filtros["cliente"] != "")
                                        $query->where("cliente", "like", "%".$filtros["cliente"]."%");
                    
                                    if (isset($filtros["vendedor"]) && $filtros["vendedor"] != "")
                                        $query->where("vendedor", "like", "%".$filtros["vendedor"]."%");
                                }
                            })
                            ->orderBy("data_hora_criacao", "desc")
                            ->get();
        } catch (\Exception $e) {
            return false;
        }

        return $orcamentos;
    }
    
    /**Função para buscar os dados de um orçamento
     * @author Lucas Magalhães
     * @param int $id - Código do orçamento
     * @return object|bool - Dados do orçamento 
     */
    public function getOrcamento(int $id) : object|bool
    {
        try {
            $dados = $this->find($id);
        } catch (\Exception $e) {
            return false;
        }

        return $dados;
    }

    /**Função para gravar o orçamento
     * @author Lucas Magalhães
     * @param array $dados - Dados do orçamento que serão gravador
     * @return bool - Confirmação da gravação
     */
    public function gravar(int $dados) : bool
    {
        try{
            $dados["valor"] = str_replace(",", ".", $dados["valor"]);
            if (is_null($dados["id"])){
                foreach($dados as $campo => $valor){
                    $this->$campo = $valor;
                }
                $this->save();
            }else{
                $this->where("id", $dados["id"])->update($dados);
            }
        }catch(\Exception $e){
            return false;
        }

        return true;
    }

    /**Função para excluir um orçamento (na realidade ele não exclui, apenas o "esconde", através de SoftDeletes)
     * @author Lucas Magalhães
     * @param int $id - Código do orçamento
     * @return bool - Confirmação da exclusão
     */
    public function excluir(int $id) : bool
    {
        try{
            return $this->find($id)->delete();
        }catch(\Exception $e){
            return false;
        }
    }
}
