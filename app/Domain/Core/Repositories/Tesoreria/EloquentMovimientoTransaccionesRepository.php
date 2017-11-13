<?php

namespace Ghi\Domain\Core\Repositories\Tesoreria;

use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Contracts\Tesoreria\TraspasoCuentasRepository;
use Ghi\Domain\Core\Models\Tesoreria\MovimientoTransacciones;
use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoTransaccion;

class EloquentMovimientoTransaccionesRepository implements TraspasoCuentasRepository
{
    /**
     * @var MovimientoTransacciones $model
     */
    private $model;
    /**
     * @var Cuentas $cuenta
     */
    private $cuenta;

    /**
     * EloquentTraspasoCuentasRepository constructor.
     * @param MovimientoTransacciones $model
     */
    public function __construct(MovimientoTransacciones $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Tesoreria\MovimientoTransaccionesRepository
     */
    public function all()
    {
        return $this->model->get();
    }

    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $record = $this->model->create($data);
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $this->model->where('id_movimiento_transaccion', '=', $record->id_movimiento_transaccion);
    }

    public function with($relations) {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Aplica un SoftDelete al Tipo de MovimientoTransacciones entre cuentas seleccionado
     * @param $id Identificador del registro de Tipo de MovimientoTransacciones entre cuentas que se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $item = $this->model->where('id_movimiento_transaccion', '=', $id);

            if (!$item) {
                throw new HttpResponseException(new Response('No se encontró el movimiento traspaso que se desea eliminar', 404));
            }

            $item->delete($id);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $id;
    }
}
