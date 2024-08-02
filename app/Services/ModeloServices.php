<?php

namespace App\Services;

use App\Http\Requests\ModeloStoreRequest;
use App\Http\Requests\ModeloUpdateRequest;
use App\Models\Modelo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModeloServices
{
    // Define os atributos permitidos para o modelo e para a relação
    protected array $allowedAttributes = ['id', 'nome', 'imagem', 'marca_id'];
    protected array $allowedMarcaAttributes = ['id', 'nome'];

    public function lista(Request $request)
    {
        try {
            $query = Modelo::with(['marca' => function($query) use ($request) {
                if ($request->has('atributos_marca')) {
                    $atributos_marca = explode(',', $request->input('atributos_marca'));

                    // Filtra os atributos permitidos
                    $atributos_marca = array_intersect($atributos_marca, $this->allowedMarcaAttributes);

                    // Adiciona 'id' se não estiver nos atributos para evitar erros de integridade
                    if (!in_array('id', $atributos_marca)) {
                        $atributos_marca[] = 'id';
                    }

                    $query->select($atributos_marca);
                }
            }]);

            if ($request->has('atributos')) {
                $atributos = explode(',', $request->input('atributos'));

                // Filtra os atributos permitidos
                $atributos = array_intersect($atributos, $this->allowedAttributes);

                // Adiciona 'id' se não estiver nos atributos para evitar erros de integridade
                if (!in_array('id', $atributos)) {
                    $atributos[] = 'id';
                }

                $query->select($atributos);
            }

            return $query->paginate(10);

        } catch (Exception $e) {
            throw new Exception('Ocorreu um erro ao processar a solicitação.');
        }
    }

    public function store(ModeloStoreRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['nome']);

        $path = $request->file('imagem')->store('imagens/modelos', 'public');
        $data['imagem'] = $path;

        return Modelo::create($data);
    }

    public function update(ModeloUpdateRequest $request, Modelo $modelo)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['nome']);

        if ($request->hasFile('imagem')) {

            if ($modelo->imagem) {
                Storage::disk('public')->delete($modelo->imagem);
            }

            $path = $request->file('imagem')->store('imagens/modelos', 'public');
            $data['imagem'] = $path;
        }

        $modelo->update($data);

        return $modelo;
    }

    public function destroy(Modelo $modelo)
    {
        if ($modelo->imagem) {
            Storage::disk('public')->delete($modelo->imagem);
        }

        $modelo->delete();
    }
}
