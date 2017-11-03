<?php

namespace Ghi\Domain\Core\Repositories\Tesoreria;

use Ghi\Domain\Core\Contracts\Tesoreria\MovimientosBancariosRepository;
use Ghi\Domain\Core\Models\Tesoreria\MovimientoTransacciones;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoCuentas;
use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Domain\Core\Models\Obra;

class EloquentMovimientosBancariosRepository implements MovimientosBancariosRepository
{
    /**
     * @var MovimientosBancarios $model
     */
    private $model;
    /**
     * @var Cuentas $cuenta
     */
    private $cuenta;

    /**
     * EloquentMovimientosBancariosRepository constructor.
     * @param MovimientosBancarios $model
     */
    public function __construct(MovimientosBancarios $model)
    {
        $this->model = $model;
        $this->cuentas = new Cuenta;
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Tesoreria\MovimientosBancarios
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

        return MovimientosBancarios::where('id_traspaso', '=', $record->id_traspaso)->with(['cuenta_destino.empresa', 'cuenta_origen.empresa', 'traspaso_transaccion.transaccion_debito'])->first();
    }

    public function with($relations) {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Aplica un SoftDelete al Tipo de MovimientosBancarios  seleccionado
     * @param $id Identificador del registro de Tipo deMovimientosBancarios que se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $item = $this->model->where('id_movimiento_bancario', '=', $id);

            if (!$item) {
                throw new HttpResponseException(new Response('No se encontró el movimiento bancario que se desea eliminar', 404));
            }

            $item->delete($id);

            // Obtener el id de los movimientos_transacciones a eliminar
            $transacciones = MovimientoTransacciones::where('id_movimiento_bancario', '=', $id)->get();

            foreach ($transacciones as $tr)
                Transaccion::where('id_transaccion', $tr->id_transaccion)
                    ->update(['estado' => '-2']);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $id;
    }

    /**
     *  Edita el movimiento bancario seleccionado
     * @param $data
     * @param $id
     * @return int $id
     * @throws \Exception
     */
    public function update($data, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();


            $item = $this->model->find($id);

            if (!$item) {
                throw new HttpResponseException(new Response('No se encontró el movimiento que se desea eliminar', 404));
            }

            $item->update($data);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $this->model->with(['cuenta_origen.empresa', 'cuenta_destino.empresa', 'traspaso_transaccion.transaccion_debito'])->find($item->id_traspaso);
    }

    public function obras()
    {
        return Obra::all();
    }
}
