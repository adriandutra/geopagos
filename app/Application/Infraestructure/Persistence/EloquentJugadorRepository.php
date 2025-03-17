<?php

namespace App\Application\Infraestructure\Persistence;

use App\Domain\Repositories\JugadorRepositoryInterface;
use App\Domain\Entities\Jugador;

class EloquentJugadorRepository implements JugadorRepositoryInterface {
    public function save(Jugador $jugador): void {
        $jugador->save();
    }
    public function findByName(string $nombre): ?Jugador {
        return Jugador::where('nombre', $nombre)->first();
    }
    public function findAll() {
        return Jugador::all();
    }

}