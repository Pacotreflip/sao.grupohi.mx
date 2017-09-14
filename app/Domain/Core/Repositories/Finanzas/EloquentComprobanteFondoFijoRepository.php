<?php

namespace Ghi\Domain\Core\Repositories\Finanzas;

use Ghi\Domain\Core\Contracts\Finanzas\ComprobanteFondoFijoRepository;
use Ghi\Domain\Core\Models\Finanzas\ComprobanteFondoFijo;
use Illuminate\Support\Facades\DB;

class EloquentComprobanteFondoFijoRepository implements ComprobanteFondoFijoRepository
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
     * Obtiene todos los registros de Comprobantes de Fondo Fijo
     * @return mixed
     */
    public function all()
    {
        return $this->model->get();
    }

    public function columns($columns = array('*')){
        return $this->model->get($columns);
    }

    /**
     * @param $id
     * @return Ghi\Domain\Core\Models\Finanzas\ComprobanteFondoFijo
     */
    public function find($id)
    {
        return $this->model->find($id);
    }


    /**
     * Guarda un nuevo registro de Comprobante de Fondo Fijo
     * @param array $data
     * @return mixed
     * @throws Exception
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

    /**
     * Actualiza un nuevo registro de Comprobante de Fondo Fijo
     * @param array $data
     * @param  $id
     * @return mixed
     * @throws Exception
     */
    public function update(array $data, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $comprobante = $this->model->find($id);
            $comprobante->update($data);


            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $comprobante;
    }

    /**
     * Elimina el Comprobante de Fondo Fijo
     * @param array $data
     * @param $id
     * @return mixed
     *
     */
    public function delete($id)
    {
        DB::connection('cadeco')->beginTransaction();
        try {
            DB::connection("cadeco")->statement("EXEC dbo.sp_borra_transaccion @id_transaccion = " . $id);
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }
}