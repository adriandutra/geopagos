<?php

namespace App\Application\Services;

use App\Domain\Entities\Jugador;

class SimulacionService {
    public function simularTorneo($jugadores) {
        while (count($jugadores) > 1) {
            $ganadores = [];
            for ($i = 0; $i < count($jugadores); $i += 2) {
                $ganador = $this->determinarGanador($jugadores[$i], $jugadores[$i + 1]);
                $ganadores[] = $ganador;
            }
            $jugadores = $ganadores;
        }
        return $jugadores[0];
    }

    private function determinarGanador(Jugador $jugador1, Jugador $jugador2) {
        $suerte = rand(0, 100) / 100;
        $puntaje1 = $jugador1->habilidad + $suerte * 50;
        $puntaje2 = $jugador2->habilidad + $suerte * 50;
        if ($jugador1->genero === 'M') {
            $puntaje1 += ($jugador1->fuerza + $jugador1->velocidad) / 2;
            $puntaje2 += ($jugador2->fuerza + $jugador2->velocidad) / 2;
        }
        return $puntaje1 >= $puntaje2 ? $jugador1 : $jugador2;
    }
}
