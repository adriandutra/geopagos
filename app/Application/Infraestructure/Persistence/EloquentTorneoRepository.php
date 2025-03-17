<?php

namespace App\Application\Infraestructure\Persistence;

use App\Domain\Repositories\TorneoRepositoryInterface;
use App\Domain\Entities\Torneo;
use App\Models\Torneo as TorneoModel;

class EloquentTorneoRepository implements TorneoRepositoryInterface {
    public function findAll() {
        return TorneoModel::all();
    }
    public function save(Torneo $torneo) {
        $torneoModel = new TorneoModel();
        $torneoModel->fill($torneo->toArray());
        return $torneoModel->save();
    }
    public function findByCriteria($fecha, $genero, $nombre) {
        $query = TorneoModel::query();
        if ($fecha) $query->whereDate('fecha', $fecha);
        if ($genero) $query->where('genero', $genero);
        if ($nombre) $query->where('nombre', $nombre);
        return $query->get();
    }
    public function findTorneosGanadosPorJugador($nombre) {
        return TorneoModel::where('ganador', $nombre)->get();
    }
    
}