<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModeloUpdateRequest extends FormRequest
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
            'marca_id' => 'required|exists:marcas,id',
            'nome' => 'required|string|min:3|max:100|unique:modelos,nome,' . $this->route('modelo')->id,
            'imagem' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'numero_portas' => 'required|integer|between:2,5',
            'lugares' => 'required|integer|between:1,5',
            'airbag' => 'required|boolean',
            'abs' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'marca_id.required' => 'A marca é obrigatória.',
            'marca_id.exists' => 'Marca inválida.',
            'nome.required' => 'O nome é obrigatório.',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O nome deve ter no máximo 100 caracteres.',
            'imagem.required' => 'A imagem é obrigatória.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve ser dos tipos: jpeg, png, jpg, gif, svg.',
            'imagem.max' => 'A imagem não pode ser maior que 2MB.',
            'numero_portas.required' => 'O número de portas é obrigatório.',
            'numero_portas.integer' => 'O número de portas deve ser um número inteiro.',
            'numero_portas.between' => 'O número de portas deve estar entre 2 e 5.',
            'lugares.required' => 'O número de lugares é obrigatório.',
            'lugares.integer' => 'O número de lugares deve ser um número inteiro.',
            'lugares.between' => 'O número de lugares deve estar entre 1 e 5',
            'airbag.required' => 'O airbag é obrigatório.',
            'airbag.boolean' => 'O airbag deve ser um valor booleano.',
            'abs.required' => 'O abs é obrigatório.',
            'abs.boolean' => 'O abs deve ser um valor booleano.'
        ];
    }
}
