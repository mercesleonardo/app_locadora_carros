<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteStoreRequest;
use App\Http\Requests\ClienteUpdateRequest;
use App\Models\Cliente;
use App\Services\ClienteServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    public function __construct(protected ClienteServices $clienteServices)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $clientes = $this->clienteServices->lista($request);
            return response()->json($clientes);
        } catch (Exception $e) {
            Log::error('Erro ao listar clientes: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar clientes'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClienteStoreRequest $request)
    {
        try {
            $cliente = $this->clienteServices->store($request);
            return response()->json($cliente);
        } catch (Exception $e) {
            Log::error('Erro ao criar cliente: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar cliente'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        try {
            return response()->json($cliente);
        } catch (Exception $e) {
            Log::error('Erro ao exibir cliente: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao exibir cliente'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClienteUpdateRequest $request, Cliente $cliente)
    {
        try {
            $cliente = $this->clienteServices->update($request, $cliente);
            return response()->json($cliente);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar cliente: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar cliente'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        try {
            $this->clienteServices->destroy($cliente);
            return response()->json(["message" => "Cliente deletado com sucesso"]);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar cliente: '. $e->getMessage());
            return response()->json(['error' => 'Erro ao deletar cliente'], 500);
        }
    }
}
