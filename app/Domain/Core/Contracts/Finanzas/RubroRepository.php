<?php

namespace Ghi\Domain\Core\Contracts\Finanzas;


use Ghi\Domain\Core\Models\Finanzas\Rubro;

interface RubroRepository
{
    /**
     * @return Rubro[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * @param array|string $with
     * @return $this|RubroRepository
     */
    public function with($with);

    /**
     * @param array|string $where Where
     * @return $this|RubroRepository
     */
    public function where($where);
}