<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/06/2018
 * Time: 01:46 PM
 */

namespace Ghi\Domain\Core\Contracts\Finanzas;


use Ghi\Domain\Core\Models\Finanzas\SolicitudRecursos;
use Ghi\Domain\Core\Repositories\Finanzas\EloquentSolicitudRecursosRepository;

interface SolicitudRecursosRepository
{
    /**
     * Crea un registro de Solicitud de Recursos con sus Partidas
     *
     * @return SolicitudRecursos|mixed
     * @throws \Exception
     */
    public function create();

    public function paginate(array $data);

    /**
     * Devuelve modelo relacionado con otros modelos
     * @param $with
     * @return EloquentSolicitudRecursosRepository
     */
    public function with($with);


    /**
     * @param $id
     * @return SolicitudRecursos|mixed
     * @throws \Exception
     */
    public function finalizar($id);
}