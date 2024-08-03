<?php

namespace App\Services;

use App\Http\Requests\MarcaStoreRequest;
use App\Http\Requests\MarcaUpdateRequest;
use App\Models\Marca;
use App\Models\Modelo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MarcaServices
{
    public function lista(Request $request)
    {
        try {
            $query = Marca::with(['modelos' => function($query) use ($request) {
                if ($request->has('atributos_modelos')) {
                    $atributos_modelos = explode(',', $request->input('atributos_modelos'));

                    if (!in_array('id', $atributos_modelos)) {
                        $atributos_modelos[] = 'id';
                    }

                    $query->select($atributos_modelos);
                }
            }]);

            if ($request->has('filtro')) {
                $filtros = explode(';', $request->input('filtro'));
                foreach ($filtros as $filtro) {
                    $condicoes = explode(':', $filtro);
                    if (count($condicoes) === 3) {
                        $query = $query->where($condicoes[0], $condicoes[1], $condicoes[2]);
                    }
                }
            }

            if ($request->has('atributos')) {
                $atributos = explode(',', $request->input('atributos'));

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

    public function store(MarcaStoreRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['nome']);

        $path = $request->file('imagem')->store('imagens', 'public');
        $data['imagem'] = $path;

        return Marca::create($data);
    }

    public function update(MarcaUpdateRequest $request, Marca $marca)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['nome']);

        if ($request->hasFile('imagem')) {

            if ($marca->imagem) {
                Storage::disk('public')->delete($marca->imagem);
            }

            $path = $request->file('imagem')->store('imagens', 'public');
            $data['imagem'] = $path;
        }

        $marca->update($data);

        return $marca;
    }

    public function destroy(Marca $marca)
    {
        if ($marca->imagem) {
            Storage::disk('public')->delete($marca->imagem);
        }

        $marca->delete();
    }
}
