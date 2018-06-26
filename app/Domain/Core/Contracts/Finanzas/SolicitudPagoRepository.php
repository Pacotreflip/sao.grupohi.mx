<?php

namespace Ghi\Domain\Core\Contracts\Finanzas;

use Ghi\Domain\Core\Repositories\Finanzas\EloquentSolicitudPagoRepository;

interface SolicitudPagoRepository
{
    /**
     * Devuelve todos los registros de solicitudes de pago
     */
    public function all();

    /**
     * Regresa registros de Solicitud de Pago paginados
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data);

    /**
     * Devuelve modelo relacionado con otros modelos
     * @param $with
     * @return EloquentSolicitudPagoRepository
     */
    public function with($with);

    /**
     * @param $conditions
     * @return EloquentSolicitudPagoRepository
     */
    public function where($conditions);
}