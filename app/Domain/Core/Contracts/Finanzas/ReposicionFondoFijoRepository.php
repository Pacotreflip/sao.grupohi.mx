<?php

namespace Ghi\Domain\Core\Contracts\Finanzas;

use Ghi\Domain\Core\Models\Finanzas\ReposicionFondoFijo;
use Illuminate\Support\Collection;

interface ReposicionFondoFijoRepository
{
    /**
     * @param array $data
     * @return mixed
     * @throws Exception
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
}