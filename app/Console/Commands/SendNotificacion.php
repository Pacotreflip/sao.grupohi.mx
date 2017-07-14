<?php

namespace Ghi\Console\Commands;

use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\NotificacionRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendNotificacion extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:notificacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar notificacion al contador de las polizas con errores';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $notificacion;
    protected $poliza;

    public function __construct(NotificacionRepository $notificacion, PolizaRepository $poliza)
    {
        parent::__construct();
        $this->notificacion = $notificacion;
        $this->poliza = $poliza;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        Log::info('fdsfdsfsdsfsdfsd');


        Log::info($polizas);


    }
}
