<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaStoreRequest;
use App\Http\Requests\ModeloStoreRequest;
use App\Http\Requests\ModeloUpdateRequest;
use App\Models\Modelo;
use App\Services\ModeloServices;
use Exception;
use Illuminate\Http\Request;

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
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModeloStoreRequest $request)
    {
           $modelo = $this->modeloServices->store($request);

           return response()->json($modelo);
    }

    /**
     * Display the specified resource.
     */
    public function show(Modelo $modelo)
    {
        $modelo->load('marca');
        return response()->json($modelo);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ModeloUpdateRequest $request, Modelo $modelo)
    {
        $modelo = $this->modeloServices->update($request, $modelo);

        return response()->json($modelo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modelo $modelo)
    {
        $this->modeloServices->destroy($modelo);

        return response()->json(["message" => "Modelo deletado com sucesso"]);
    }
}
