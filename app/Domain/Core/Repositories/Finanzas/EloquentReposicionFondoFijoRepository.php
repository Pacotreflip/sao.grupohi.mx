<?php

namespace Ghi\Domain\Core\Repositories\Finanzas;

use Ghi\Domain\Core\Contracts\Finanzas\ReposicionFondoFijoRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ConceptoSinPath;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Finanzas\ComprobanteFondoFijo;
use Illuminate\Support\Facades\DB;

class EloquentReposicionFondoFijoRepository implements ReposicionFondoFijoRepository
{
    /**
     * @var ComprobanteFondoFijo
     */
    protected $model;

    /**
     * EloquentComprobanteFondoFijoRepository constructor.
     * @param ComprobanteFondoFijo $model
     */
    public function __construct(ComprobanteFondoFijo $model)
    {
        $this->model = $model;
    }

    /**
     * Guarda un nuevo registro de Comprobante de Fondo Fijo
     * @param array $data
     * @return mixed
     * @throws Exception
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $item = $this->model->create($data);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $item;

    }
}