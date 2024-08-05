<?php

namespace App\Services;

use App\Http\Requests\ClienteStoreRequest;
use App\Http\Requests\ClienteUpdateRequest;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClienteServices
{
    public function __construct(protected ClienteRepository $clienteRepository)
    {
    }
    public function lista(Request $request)
    {
        try {
//            if ($request->has('atributos_modelos')) {
//                $atributos_modelos = 'modelo:id,' . $request->atributos_modelos;
//                $this->clienteRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
//            } else {
//                $this->clienteRepository->selectAtributosRegistrosRelacionados('modelo');
//            }

            if ($request->has('filtro')) {
                $this->clienteRepository->filtro($request->filtro);
            }

            if ($request->has('atributos')) {
                $this->clienteRepository->selectAtributos($request->atributos);
            }

            return $this->clienteRepository->getResultado()->paginate(10);
        } catch (Exception $e) {
            Log::error('Erro ao listar clientes: ' . $e->getMessage());
            throw new Exception('Erro ao listar clientes');
        }
    }

    public function store(ClienteStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['nome']);
            return Cliente::create($data);
        } catch (Exception $e) {
            Log::error('Erro ao criar cliente: ' . $e->getMessage());
            throw new Exception('Erro ao criar cliente');
        }
    }

    public function update(ClienteUpdateRequest $request, Cliente $cliente)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['nome']);
            $cliente->update($data);
            return $cliente;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar cliente: ' . $e->getMessage());
            throw new Exception('Erro ao atualizar cliente');
        }
    }

    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();
        } catch (Exception $e) {
            Log::error('Erro ao deletar cliente: ' . $e->getMessage());
            throw new Exception('Erro ao deletar cliente');
        }
    }
}
