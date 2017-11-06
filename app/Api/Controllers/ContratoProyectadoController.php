<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/11/2017
 * Time: 5:13 AM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Repositories\EloquentContratoProyectadoRepository;
use Ghi\Http\Controllers\Controller;

class ContratoProyectadoController extends Controller
{
    use Helpers;

    private $contrato_proyectado;

    public function __construct(EloquentContratoProyectadoRepository $contrato_proyectado)
    {
        $this->contrato_proyectado = $contrato_proyectado;
    }

    public function store(Request $request)
    {
        // TODO
    }

    public function update() {

    }
}