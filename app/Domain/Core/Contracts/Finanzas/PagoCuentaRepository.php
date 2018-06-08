<?php

namespace Ghi\Domain\Core\Contracts\Finanzas;

use Ghi\Domain\Core\Models\TipoTransaccion;
use Illuminate\Database\Eloquent\Collection;

interface PagoCuentaRepository
{
    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * @param array $where
     *
     * @return mixed
     */
    public function where(array $where);

    /**
     * @return mixed
     */
    public function get();

    /**
     * Devuelve lis tipos de transacción que se utilizan en las solicitudes de cheque de pago a cuenta
     * @return Collection | TipoTransaccion
     */
    public function getTiposTran();
}