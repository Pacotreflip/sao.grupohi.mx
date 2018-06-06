<?php

namespace Ghi\Domain\Core\Contracts\Finanzas;

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
}