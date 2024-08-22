<?php

namespace App\Services;

use App\Http\Requests\CarroStoreRequest;
use App\Http\Requests\CarroUpdateRequest;
use App\Models\Carro;
use App\Repositories\CarroRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CarroServices
{
    public function __construct(protected CarroRepository $carroRepository)
    {}
    public function lista(Request $request)
    {
        if ($request->has('atributos_modelos')) {
            $atributos_modelos = 'modelo:id,' . $request->atributos_modelos;
            $this->carroRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
        } else {
            $this->carroRepository->selectAtributosRegistrosRelacionados('modelo');
        }

        if ($request->has('filtro')) {
            $this->carroRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $this->carroRepository->selectAtributos($request->atributos);
        }

        return $this->carroRepository->getResultado()->paginate(10);
    }

    public function store(CarroStoreRequest $request)
    {
        $data = $request->validated();
        $data['placa'] = strtoupper($request->placa);
        return Carro::create($data);
    }

    public function update(CarroUpdateRequest $request, Carro $carro)
    {
        $data = $request->validated();
        $data['placa'] = strtoupper($request->placa);
        $carro->update($data);
        return $carro;
    }

    public function destroy(Carro $carro)
    {
        $carro->delete();
    }
}
