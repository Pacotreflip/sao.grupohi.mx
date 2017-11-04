<?php

namespace Ghi\Domain\Core\Repositories\Tesoreria;

use Ghi\Domain\Core\Contracts\Tesoreria\TraspasoTransaccionRepository;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoCuentas;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoTransaccion;

class EloquentTraspasoTransaccionRepository implements TraspasoTransaccionRepository
{
    /**
     * @var TraspasoTransaccion $model
     */
    private $model;

    /**
     * EloquentTraspasoCuentasRepository constructor.
     * @param TransaccionInterfaz $model
     */
    public function __construct(TraspasoTransaccion $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Contabilidad\TraspasoCuentas
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Guartdar un nuevo registro
     * @param array $data
     * @return TraspasoCuentas
     * @throws \Exception
     */
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
        return $this->model->where('id_traspaso_transaccion', '=', $record->id_traspaso_transaccion);
    }

    public function with($relations) {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Aplica un SoftDelete al Tipo de Traspaso entre cuentas seleccionado
     * @param $id Identificador del registro de Tipo de Traspaso entre cuentas que se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $item = $this->model->where('id_traspaso_transaccion', '=', $id);

            if (!$item) {
                throw new HttpResponseException(new Response('No se encontró el traspaso que se desea eliminar', 404));
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
