<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarcaUpdateRequest extends FormRequest
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
            'nome' => 'required|string|max:255|unique:marcas,nome,' . $this->marca->id,
            'imagem' => 'required|string'
//            'imagem' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
