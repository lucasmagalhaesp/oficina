<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrcamentosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Regras de validação para o cadastro de orçamentos*/
    public function rules(): array
    {
        return [
            "dados.cliente"             => "required|min:2",
            "dados.vendedor"            => "required|min:2",
            "dados.descricao"           => "required|min:5|max:1000",
            "dados.valor"               => "required|regex:/^\d*(\,\d{2})?$/",
            "dados.data_hora_criacao"   => "required|date",
        ];
    }

    /** Mensagens de erro para o usuário */
    public function messages(): array
    {
        return [
            "dados.cliente.required"            => "Cliente não informado",
            "dados.cliente.min"                 => "Nome do cliente deve ter pelo menos 2 caracteres",
            "dados.vendedor.required"           => "Vendedor não informado",
            "dados.vendedor.min"                => "Nome do vendedor deve ter pelo menos 2 caracteres",
            "dados.descricao.required"          => "Descrição do orçamento não informada",
            "dados.descricao.min"               => "A descrição do orçamento deve ter pelo menos 5 caracteres",
            "dados.descricao.max"               => "A descrição do orçamento deve ter no máximo 1000 caracteres",
            "dados.valor.required"              => "Valor não informado",
            "dados.valor.regex"                 => "Valor inválido",
            "dados.data_hora_criacao.required"  => "Data/hora de criação do orçamento não informados",
            "dados.data_hora_criacao.date"      => "Data/hora do orçamento é inválida",
        ];
    }
}
