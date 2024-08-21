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
        if ($request->has('filtro')) {
            $this->clienteRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $this->clienteRepository->selectAtributos($request->atributos);
        }

        return $this->clienteRepository->getResultado()->paginate(10);
    }

    public function store(ClienteStoreRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['nome']);
        return Cliente::create($data);
    }

    public function update(ClienteUpdateRequest $request, Cliente $cliente)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['nome']);
        $cliente->update($data);
        return $cliente;
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
    }
}
