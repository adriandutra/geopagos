<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Torneo;

interface TorneoRepositoryInterface {
    public function save(Torneo $torneo);
    public function findByCriteria($fecha, $genero, $jugador);
    public function findAll();
}
