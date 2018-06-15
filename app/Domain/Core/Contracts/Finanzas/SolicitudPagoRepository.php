<?php

namespace Ghi\Domain\Core\Contracts\Finanzas;

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
}