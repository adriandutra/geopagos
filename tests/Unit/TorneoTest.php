<?php 

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Domain\Entities\Jugador;
use App\Domain\Entities\Torneo;
use App\Application\Services\SimulacionService;
use App\Domain\Repositories\TorneoRepositoryInterface;
use App\Domain\Repositories\JugadorRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TorneoTest extends TestCase {
    
    use DatabaseMigrations;
    use RefreshDatabase;

    private $torneoRepo;
    private $jugadorRepo;
    private $simulacionService;

    protected function setUp(): void {
        parent::setUp();
        $this->torneoRepo = Mockery::mock(TorneoRepositoryInterface::class);
        $this->jugadorRepo = Mockery::mock(JugadorRepositoryInterface::class);
        $this->simulacionService = new SimulacionService();
    }

    public function test_crear_jugador() {
        $jugador = new Jugador();
        $jugador->nombre = "Juan Pérez";
        $jugador->habilidad = 800;
        $jugador->genero = "M";
        $jugador->fuerza = 500;
        $jugador->velocidad = 600;

        $this->assertEquals("Juan Pérez", $jugador->nombre);
        $this->assertEquals(800, $jugador->habilidad);
        $this->assertEquals("M", $jugador->genero);
    }

    public function test_simulacion_partido() {
        $jugador1 = new Jugador();
        $jugador1->nombre = "Jugador 1";
        $jugador1->habilidad = 900;
        
        $jugador2 = new Jugador();
        $jugador2->nombre = "Jugador 2";
        $jugador2->habilidad = 700;
        
        $ganador = $this->simulacionService->simularPartido($jugador1, $jugador2);
        
        $this->assertContains($ganador, [$jugador1, $jugador2]);
    }

    public function test_iniciar_torneo() {
        $jugadores = collect([
            new Jugador(['nombre' => 'Jugador 1', 'genero'=> 'M','habilidad' => 900]),
            new Jugador(['nombre' => 'Jugador 2', 'genero'=> 'M','habilidad' => 800]),
            new Jugador(['nombre' => 'Jugador 3', 'genero'=> 'M','habilidad' => 700]),
            new Jugador(['nombre' => 'Jugador 4', 'genero'=> 'M','habilidad' => 600])
        ]);
        
        $ganador = $this->simulacionService->simularTorneo($jugadores);
        $this->assertInstanceOf(Jugador::class, $ganador);
    }
}
