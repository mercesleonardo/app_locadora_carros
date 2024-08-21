<?php

namespace App\Services;

use App\Http\Requests\MarcaStoreRequest;
use App\Http\Requests\MarcaUpdateRequest;
use App\Models\Marca;
use App\Models\Modelo;
use App\Repositories\MarcaRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MarcaServices
{
    public function __construct(protected MarcaRepository $marcaRepository)
    {
    }
    public function lista(Request $request)
    {
        if ($request->has('atributos_modelos')) {
            $atributos_modelos = 'modelos:id,' . $request->atributos_modelos;
            $this->marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
        } else {
            $this->marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if ($request->has('filtro')) {
            $this->marcaRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $this->marcaRepository->selectAtributos($request->atributos);
        }

        return $this->marcaRepository->getResultado()->paginate(3);

    }

    public function store(MarcaStoreRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['nome']);

        $path = $request->file('imagem')->store('imagens/marcas', 'public');
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

            $path = $request->file('imagem')->store('imagens/marcas', 'public');
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
