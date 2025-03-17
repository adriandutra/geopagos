<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Application\Services\SimulacionService;
use App\Domain\Repositories\TorneoRepositoryInterface;
use App\Domain\Repositories\JugadorRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Domain\Entities\Torneo;
use App\Domain\Entities\Jugador;
use Carbon\Carbon;

class TorneoController extends Controller {
    private $torneoRepo;
    private $jugadorRepo;
    private $simulacionService;

    public function __construct(TorneoRepositoryInterface $torneoRepo, JugadorRepositoryInterface $jugadorRepo, SimulacionService $simulacionService) {
        $this->torneoRepo = $torneoRepo;
        $this->jugadorRepo = $jugadorRepo;
        $this->simulacionService = $simulacionService;
    }

    public function iniciarTorneo(Request $request) {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'genero' => 'required|string|in:M,F',
            'jugadores' => 'required|array|min:2',
            'jugadores.*.nombre' => 'required|string',
            'jugadores.*.habilidad' => 'required|integer|min:0|max:1000',
            'jugadores.*.genero' => 'required|string|in:M,F',
            'jugadores.*.fuerza' => 'nullable|integer|min:0|max:1000',
            'jugadores.*.velocidad' => 'nullable|integer|min:0|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $datos = $validator->validated();

        $jugadores = collect($datos['jugadores'])->map(function ($j) use ($datos) {
            if ($j['genero'] !== $datos['genero']) {
                abort(400, 'Todos los jugadores deben ser del mismo género que el torneo.');
            }
            $jugador = new Jugador();
            $jugador->nombre = $j['nombre'];
            $jugador->habilidad = $j['habilidad'];
            $jugador->genero = $j['genero'];
            $jugador->fuerza = $j['fuerza'] ?? null;
            $jugador->velocidad = $j['velocidad'] ?? null;
            $this->jugadorRepo->save($jugador);
            return $jugador;
        });
        
        $ganador = $this->simulacionService->simularTorneo($jugadores);

        $torneo = new Torneo();
        $torneo->nombre = $datos['nombre'];
        $torneo->genero = $datos['genero'];
        $torneo->fecha = Carbon::now();
        $torneo->setGanador($ganador->id);
        $torneo->jugadores = json_encode($datos['jugadores']);

        $this->torneoRepo->save($torneo);

        return response()->json(['ganador' => $ganador->nombre]);
    }

    public function consultarTorneos(Request $request) {
        $torneos = $this->torneoRepo->findByCriteria(
            $request->query('fecha'), 
            $request->query('genero'), 
            $request->query('nombre')
        );
        return response()->json($torneos);
    }

    public function consultarJugador($nombre) {
        $jugador = $this->jugadorRepo->findByName($nombre);
        if (!$jugador) {
            return response()->json(['message' => 'Jugador no encontrado'], 404);
        }
        $torneosGanados = $this->torneoRepo->findByCriteria(null, null, $jugador->nombre);
        return response()->json(['jugador' => $jugador, 'torneos_ganados' => $torneosGanados]);
    }
}