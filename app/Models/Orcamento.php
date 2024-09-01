<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getOrcamentos($filtros)
    {
        try {
            $orcamentos = $this->orderBy("id", "desc")
                            ->where(function ($query) use ($filtros){
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
                            ->get();
        } catch (\Exception $e) {
            return false;
        }

        return $orcamentos;
    }

    public function gravarOrcamento($dados)
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
}
