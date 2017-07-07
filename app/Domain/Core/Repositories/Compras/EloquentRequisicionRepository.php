<?php

namespace Ghi\Domain\Core\Repositories\Compras;

use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Models\Compras\Requisiciones\DepartamentoResponsable;
use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Ghi\Domain\Core\Models\Compras\Requisiciones\TipoRequisicion;
use Ghi\Domain\Core\Models\Compras\Requisiciones\TransaccionExt;
use Illuminate\Support\Facades\DB;

class EloquentRequisicionRepository implements RequisicionRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion
     */
    protected $model;

    /**
     * @var \Ghi\Domain\Core\Models\Compras\Requisiciones\TransaccionExt
     */
    protected $ext;

    /**
     * EloquentRequisicionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion $model
     */
    public function __construct(Requisicion $model, TransaccionExt $ext)
    {
        $this->model = $model;
        $this->ext = $ext;
    }

    /**
     * Obtiene todos los registros de Requisicion
     *
     * @return \Illuminate\Database\Eloquent\Collection|Requisicion
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|Requisicion
     */
    public function find($id)
    {
        return $this->model->find($id);
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

    /**
     * Guarda un registro de Transaccion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $item = $this->model->create($data);

            $this->ext->create([
                'id_transaccion' => $item->id_transaccion,
                'id_departamento' => $data['id_departamento'],
                'id_tipo_requisicion' => $data['id_tipo_requisicion']
            ]);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $this->model->with('transaccionExt')->find($item->id_transaccion);
    }

    /**
     * Actualiza un registro de Transaccion
     * @param array $data
     * @param integer $id
     * @return \Ghi\Domain\Core\Models\Transacciones\Transaccion
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {

            DB::connection('cadeco')->beginTransaction();
            if (!$requisicion = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la requisición', 404));
            }

            $requisicion_ext = $this->ext->find($id);
            $requisicion->update($data);
            $requisicion_ext->update($data);

            $requisicion_ext->folio_adicional =
                DepartamentoResponsable::find($requisicion_ext->id_departamento)->descripcion_corta
                . '-'
                . TipoRequisicion::find($requisicion_ext->id_tipo_requisicion)->descripcion_corta
                . '-'
                . Requisicion::find($requisicion_ext->id_transaccion)->numero_folio;
            $requisicion_ext->save();

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $this->model->with('transaccionExt')->find($requisicion->id_transaccion);
    }

    /**
     * Elimina una Requisicion
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        if (!$requisicion = $this->model->find($id)) {
            throw new HttpResponseException(new Response('No se encontró la requisición', 404));
        }
        $requisicion->delete();
    }
}