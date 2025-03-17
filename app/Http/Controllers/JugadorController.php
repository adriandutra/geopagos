<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Repositories\JugadorRepositoryInterface;

class JugadorController extends Controller {
    private $jugadorRepo;

    public function __construct(JugadorRepositoryInterface $jugadorRepo) {
        $this->jugadorRepo = $jugadorRepo;
    }

    public function listarJugadores() {
        return response()->json($this->jugadorRepo->findAll());
    }
}