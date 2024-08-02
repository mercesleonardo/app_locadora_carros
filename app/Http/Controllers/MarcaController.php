<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaStoreRequest;
use App\Http\Requests\MarcaUpdateRequest;
use App\Models\Marca;
use App\Services\MarcaServices;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function __construct(protected MarcaServices $marcaServices)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = $this->marcaServices->lista();

        return response()->json($marcas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarcaStoreRequest $request)
    {
        $marca = $this->marcaServices->store($request);

        return response()->json($marca);
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $marca)
    {
        $marca->load('modelos');
        return response()->json($marca);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MarcaUpdateRequest $request, Marca $marca)
    {

        $marca = $this->marcaServices->update($request, $marca);

        return response()->json($marca);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marca $marca)
    {
        $this->marcaServices->destroy($marca);

        return response()->json(["message" => "Marca deletada com sucesso"]);
    }
}
