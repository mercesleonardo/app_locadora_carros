<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocacaoStoreRequest;
use App\Http\Requests\LocacaoUpdateRequest;
use App\Models\Locacao;
use App\Services\LocacaoServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocacaoController extends Controller
{
    public function __construct(protected LocacaoServices $locacaoServices)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $locacaos = $this->locacaoServices->lista($request);
            return response()->json($locacaos);
        } catch (Exception $e) {
            Log::error('Erro ao listar locações: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar locações'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocacaoStoreRequest $request)
    {
        try {
            $locacao = $this->locacaoServices->store($request);
            return response()->json($locacao);
        } catch (Exception $e) {
            Log::error('Erro ao criar locação: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar locação'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Locacao $locacao)
    {
        try {
            return response()->json($locacao);
        } catch (Exception $e) {
            Log::error('Erro ao exibir a locação: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao exibir a locação'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocacaoUpdateRequest $request, Locacao $locacao)
    {
        try {
            $locacao = $this->locacaoServices->update($request, $locacao);
            return response()->json($locacao);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar a locação: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar a locação'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Locacao $locacao)
    {
        try {
            $this->locacaoServices->destroy($locacao);
            return response()->json(["message" => "Locação deletada com sucesso"]);
        } catch (Exception $e) {
            Log::error('Erro ao deletar a locacao: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao deletar a locação'], 500);
        }
    }
}
