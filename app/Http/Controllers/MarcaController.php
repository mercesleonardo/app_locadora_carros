<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaStoreRequest;
use App\Http\Requests\MarcaUpdateRequest;
use App\Models\Marca;
use App\Services\MarcaServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarcaController extends Controller
{
    public function __construct(protected MarcaServices $marcaServices)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $marcas = $this->marcaServices->lista($request);
            return response()->json($marcas);
        } catch (Exception $e) {
            Log::error('Erro ao listar marcas: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar marcas'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarcaStoreRequest $request)
    {
        try {
            $marca = $this->marcaServices->store($request);
            return response()->json($marca);
        } catch (Exception $e) {
            Log::error('Erro ao criar marca: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar marca'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $marca)
    {
        try {
            $marca->load('modelos');
            return response()->json($marca);
        } catch (Exception $e) {
            Log::error('Erro ao exibir marca: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao exibir marca'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MarcaUpdateRequest $request, Marca $marca)
    {
        try {
            $marca = $this->marcaServices->update($request, $marca);
            return response()->json([$marca, "message" => "Marca Editada com sucesso"], 200);
        } catch (Exception $e) {
            Log::error('Erro ao editar marca: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao editar marca'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marca $marca)
    {
        try {
            $this->marcaServices->destroy($marca);
            return response()->json(["message" => "Marca deletada com sucesso"], 200);
        } catch (Exception $e) {
            Log::error('Erro ao deletar marca: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao deletar marca'], 500);
        }
    }
}
