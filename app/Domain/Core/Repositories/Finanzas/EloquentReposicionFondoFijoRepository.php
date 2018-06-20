<?php

namespace Ghi\Domain\Core\Repositories\Finanzas;

use Ghi\Domain\Core\Contracts\Finanzas\ReposicionFondoFijoRepository;
use Ghi\Domain\Core\Models\Finanzas\ReposicionFondoFijo;
use Illuminate\Support\Facades\DB;

class EloquentReposicionFondoFijoRepository implements ReposicionFondoFijoRepository
{
    /**
     * @var ReposicionFondoFijo
     */
    protected $model;

    /**
     * EloquentReposicionFondoFijoRepository constructor.
     * @param ReposicionFondoFijo $model
     */
    public function __construct(ReposicionFondoFijo $model)
    {
        $this->model = $model;
    }

    /**
     * Guarda un nuevo registro de Reposición de Fondo Fijo
     * @param array $data
     * @return mixed
     * @throws Exception
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $record = $this->model->create($data);
            $record->rubros()->attach($data['id_rubro']);
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $record;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where)
    {
        return  $this->model->where($where);
    }


    /**
     * @return mixed
     */
    public function get()
    {
        return $this->model->get();
    }
}