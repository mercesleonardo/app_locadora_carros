<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocacaoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'carro_id' => 'required|unique:carros,id|exists:carros,id',
            'data_inicio_periodo' => 'required|date',
            'data_final_previsto_periodo' => 'required|date',
            'valor_diaria' => 'required|numeric',
            'km_inicial' => 'required|integer',
            'km_final' => 'required|integer'
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'O cliente é obrigatório.',
            'cliente_id.exists' => 'Cliente inválido.',
            'carro_id.required' => 'O carro é obrigatório.',
            'carro_id.exists' => 'Carro inválido.',
            'carro_id.unique' => 'O carro solicitado já está locado',
            'data_inicio_periodo.required' => 'A data de início do período é obrigatória.',
            'data_inicio_periodo.date' => 'A data de início do período deve ser uma data válida.',
            'data_final_previsto_periodo.required' => 'A data final prevista do período é obrigatória.',
            'data_final_previsto_periodo.date' => 'A data final prevista do período deve ser uma data válida.',
            'valor_diaria.required' => 'O valor da diária é obrigatório.',
            'valor_diaria.numeric' => 'O valor da diária deve ser um número.',
            'km_inicial.required' => 'A quilometragem inicial é obrigatória.',
            'km_inicial.integer' => 'A quilometragem inicial deve ser um número inteiro.',
            'km_final.required' => 'A quilometragem final é obrigatória.',
            'km_final.integer' => 'A quilometragem final deve ser um número inteiro.'
        ];
    }
}
