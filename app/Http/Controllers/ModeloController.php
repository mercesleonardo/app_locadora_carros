<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaStoreRequest;
use App\Http\Requests\ModeloStoreRequest;
use App\Http\Requests\ModeloUpdateRequest;
use App\Models\Modelo;
use App\Services\ModeloServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModeloController extends Controller
{
    public function __construct(protected ModeloServices $modeloServices)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $modelos = $this->modeloServices->lista($request);
            return response()->json($modelos);
        } catch (Exception $e) {
            Log::error('Erro ao listar modelos: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar modelos'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModeloStoreRequest $request)
    {
        try {
            $modelo = $this->modeloServices->store($request);
            return response()->json($modelo);
        } catch (Exception $e) {
            Log::error('Erro ao criar modelo: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar modelo'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Modelo $modelo)
    {
        try {
            $modelo->load('marca');
            return response()->json($modelo);
        } catch (Exception $e) {
            Log::error('Erro ao exibir modelo: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao exibir modelo'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModeloUpdateRequest $request, Modelo $modelo)
    {
        try {
            $modelo = $this->modeloServices->update($request, $modelo);
            return response()->json($modelo);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar modelo: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar modelo'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modelo $modelo)
    {
        try {
            $this->modeloServices->destroy($modelo);
            return response()->json(["message" => "Modelo deletado com sucesso"]);
        } catch (Exception $e) {
            Log::error('Erro ao deletar modelo: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao deletar modelo'], 500);
        }
    }
}
