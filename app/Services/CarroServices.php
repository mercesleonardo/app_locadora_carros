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
    {
    }
    public function lista(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            Log::error('Erro ao listar carros: ' . $e->getMessage());
            throw new Exception('Erro ao listar carros');
        }
    }

    public function store(CarroStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $data['placa'] = strtoupper($request->placa);
            return Carro::create($data);
        } catch (Exception $e) {
            Log::error('Erro ao criar carro: ' . $e->getMessage());
            throw new Exception('Erro ao criar carro');
        }
    }

    public function update(CarroUpdateRequest $request, Carro $carro)
    {
        try {
            $data = $request->validated();
            $data['placa'] = strtoupper($request->placa);
            $carro->update($data);
            return $carro;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar carro: ' . $e->getMessage());
            throw new Exception('Erro ao atualizar carro');
        }
    }

    public function destroy(Carro $carro)
    {
        try {
            $carro->delete();
        } catch (Exception $e) {
            Log::error('Erro ao deletar carro: ' . $e->getMessage());
            throw new Exception('Erro ao deletar carro');
        }
    }
}
