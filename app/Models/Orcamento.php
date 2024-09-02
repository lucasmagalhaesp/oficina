<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orcamento extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    const DELETED_AT = "data_hora_exclusao";

    public function getDados($filtros)
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

    public function getOrcamento($id)
    {
        return $this->find($id);
    }

    public function gravar($dados)
    {
        $dados["valor"] = str_replace(",", ".", $dados["valor"]);
        if (is_null($dados["id"])){
            foreach($dados as $campo => $valor){
                $this->$campo = $valor;
            }
            $this->save();
        }else{
            $this->where("id", $dados["id"])->update($dados);
        }
    }

    public function excluir($id)
    {
        return $this->find($id)->delete();
    }
}
