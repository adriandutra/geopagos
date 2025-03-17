<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Torneo extends Model {
    
    protected $table = 'torneos';

    protected $fillable = ['nombre', 'genero', 'fecha', 'jugadores', 'ganador'];
    protected $casts = ['fecha' => 'datetime'];

    public function setGanador(int $jugadorId)
    {
        $this->ganador = $jugadorId;
    }

    public function ganador()
    {
        return $this->belongsTo(Jugador::class, 'ganador');
    }
}