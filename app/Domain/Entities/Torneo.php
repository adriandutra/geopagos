<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Torneo extends Model
{
    protected $table = 'torneos';
    protected $fillable = ['nombre', 'genero', 'fecha', 'jugadores', 'ganador_id'];

    public function setGanador(int $jugadorId)
    {
        $this->ganador_id = $jugadorId;
    }

    public function ganador()
    {
        return $this->belongsTo(Jugador::class, 'ganador_id');
    }
}
