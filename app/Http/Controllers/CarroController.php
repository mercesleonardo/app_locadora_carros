<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarroStoreRequest;
use App\Http\Requests\CarroUpdateRequest;
use App\Models\Carro;
use App\Services\CarroServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CarroController extends Controller
{
    public function __construct(protected CarroServices $carroServices)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $carros = $this->carroServices->lista($request);
            return response()->json($carros);
        } catch (Exception $e) {
            Log::error('Erro ao listar carros: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar carros'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarroStoreRequest $request)
    {
        try {
            $carro = $this->carroServices->store($request);
            return response()->json($carro);
        } catch (Exception $e) {
            Log::error('Erro ao criar carro: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar carro'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Carro $carro)
    {
        try {
            $carro->load('modelo');
            return response()->json($carro);
        } catch (Exception $e) {
            Log::error('Erro ao exibir carro: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao exibir carro'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarroUpdateRequest $request, Carro $carro)
    {

        try {
            $carro = $this->carroServices->update($request, $carro);
            return response()->json($carro);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar carro: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar carro'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carro $carro)
    {
        try {
            $this->carroServices->destroy($carro);
            return response()->json(["message" => "Carro deletada com sucesso"]);
        } catch (Exception $e) {
            Log::error('Erro ao deletar carro: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao deletar carro'], 500);
        }
    }
}
