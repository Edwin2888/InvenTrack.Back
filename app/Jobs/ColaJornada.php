<?php

namespace App\Jobs;

use App\Models\Registradora;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ColaJornada implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     */
    protected $idRegistrado = null;
    public function __construct($id)
    {
        $this->idRegistrado = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $movimientoRegistradora = Registradora::find($this->idRegistrado);
        $movimientoRegistradora->descripcion = 'Correcto job';
        $movimientoRegistradora->save();
    }
}
