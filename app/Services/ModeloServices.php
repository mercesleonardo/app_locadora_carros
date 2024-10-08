<?php

namespace App\Services;

use App\Http\Requests\ModeloStoreRequest;
use App\Http\Requests\ModeloUpdateRequest;
use App\Models\Modelo;
use App\Repositories\ModeloRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ModeloServices
{
    public function __construct(protected ModeloRepository $modeloRepository)
    {
    }

    public function lista(Request $request)
    {
        if ($request->has('atributos_marca')) {
            $atributos_marca = 'marca:id,' . $request->atributos_marca;

            $this->modeloRepository->selectAtributosRegistrosRelacionados($atributos_marca);
        } else {
            $this->modeloRepository->selectAtributosRegistrosRelacionados('marca');
        }

        if ($request->has('filtro')) {
            $this->modeloRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $this->modeloRepository->selectAtributos($request->atributos);
        }

        return $this->modeloRepository->getResultado()->paginate(10);
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
