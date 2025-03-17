<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model {
    protected $table = 'jugadores';
    protected $fillable = ['nombre', 'habilidad', 'genero', 'fuerza', 'velocidad'];
    
    public function torneosGanados()
    {
        return $this->hasMany(Torneo::class, 'ganador_id');
    }
}
