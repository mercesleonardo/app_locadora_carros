<?php

use App\Http\Controllers\CarroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResources([
    'carro' => CarroController::class,
    'cliente' => ClienteController::class,
    'modelo' => ModeloController::class,
    'marca' => MarcaController::class,
    'locacao' => LocacaoController::class
]);
