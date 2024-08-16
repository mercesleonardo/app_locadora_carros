<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarcaStoreRequest extends FormRequest
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
            'nome' => 'required|string|max:255|unique:marcas',
            'imagem' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.unique' => 'Este nome já está em uso.',
            'imagem.required' => 'A imagem é obrigatória.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.file' => 'A imagem precisa ser um arquivo',
            'imagem.mimes' => 'A imagem deve ser dos tipos: jpeg, png, jpg, gif, svg.',
            'imagem.max' => 'A imagem não pode ser maior que 2MB.'
        ];
    }

}
