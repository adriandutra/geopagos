<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Jugador;

interface JugadorRepositoryInterface {
    public function save(Jugador $jugador);
    public function findByName(string $nombre): ?Jugador;
    public function findAll();
}
