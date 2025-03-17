<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TorneoController;
use App\Http\Controllers\JugadorController;

//Route::post('api/torneo', [TorneoController::class, 'iniciarTorneo']);

Route::prefix('v1')->group(function () {
    Route::post('/torneo', [TorneoController::class, 'iniciarTorneo']);
    Route::get('/torneos', [TorneoController::class, 'consultarTorneos']);
    Route::get('/jugador/{nombre}', [TorneoController::class, 'consultarJugador']);
    Route::get('/jugadores', [JugadorController::class, 'listarJugadores']);
});