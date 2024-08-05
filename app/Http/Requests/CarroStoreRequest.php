<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarroStoreRequest extends FormRequest
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
            'modelo_id' => 'required|exists:modelos,id',
            'placa' => 'required|string|size:7|unique:carros',
            'disponivel' => 'required|boolean',
            'km' => 'required|integer'
        ];
    }

    public function messages(): array
    {
        return [
            'modelo_id.required' => 'O modelo é obrigatório.',
            'modelo_id.exists' => 'Modelo inválido.',
            'placa.required' => 'A placa é obrigatória.',
            'placa.size' => 'A placa precisa ter 7 caracteres.',
            'placa.unique' => 'Esta placa já está em uso.',
            'disponivel.required' => 'A disponibilidade é obrigatória.',
            'disponivel.boolean' => 'O disponibilidade deve ser um valor booleano.',
            'kd.required' => 'O km é obrigatório.',
            'km.integer' => 'A quilometragem deve ser um número inteiro.'
        ];
    }
}
