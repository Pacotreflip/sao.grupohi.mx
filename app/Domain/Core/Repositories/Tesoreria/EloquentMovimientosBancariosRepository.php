<?php

namespace Ghi\Domain\Core\Repositories\Tesoreria;

use Ghi\Domain\Core\Contracts\Tesoreria\MovimientosBancariosRepository;
use Ghi\Domain\Core\Models\Tesoreria\MovimientosBancarios;
use Ghi\Domain\Core\Models\Tesoreria\MovimientoTransacciones;
use Ghi\Domain\Core\Models\Tesoreria\TipoMovimiento;
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
        // Naturaloeza => tipo de transaccion
        $tipos_transaccion = [
            1 => 83,
            2 => 84
        ];
        $tipo = 0;

        $tipos_movimientos = TipoMovimiento::get();

        $obras = $this->obras();
        $id_obra = session()->get('id');
        $id_moneda = 0;

        foreach ($obras as $o)
            if ($o->id_obra == $id_obra)
                $id_moneda = $o->id_moneda;

        foreach ( $tipos_movimientos as $t)
            if ($t->id_tipo_movimiento == $data['id_tipo_movimiento'])
                $tipo = $tipos_transaccion[$t->naturaleza];

        try {
            DB::connection('cadeco')->beginTransaction();

            $record = MovimientosBancarios::create($data);
            DB::connection('cadeco')->commit();

            $transaccion = Transaccion::create([
                'tipo_transaccion' => $tipo,
                'estado' => 1,
                'fecha' => $data['fecha'] ? $data['fecha'] : date('Y-m-d'),
                'id_obra' => $id_obra,
                'id_cuenta' => $data['id_cuenta'],
                'id_moneda' => $id_moneda,
                'cumplimiento' => $data['cumplimiento'] ? $data['cumplimiento'] : date('Y-m-d'),
                'vencimiento' => $data['vencimiento'] ? $data['vencimiento'] : date('Y-m-d'),
                'opciones' => 1,
                'monto' => $data['importe'] +$data['impuesto'],
                'impuesto' => $data['impuesto'],
                'referencia' => $data['referencia'],
                'comentario' => "I;". date("d/m/Y") ." ". date("h:s") .";". auth()->user()->usuario,
                'observaciones' => $data['observaciones'],
                'FechaHoraRegistro' => date('Y-m-d h:i:s'),
            ]);

            // Revisa si la transaccion se guardó
            $transaccion_realizo = Transaccion::where('id_transaccion', $transaccion->id_transaccion);

            if (!$transaccion_realizo)
            {
                DB::connection('cadeco')->rollBack();
                $error = 'No se pudo concretar la transacción';
                throw new HttpResponseException(new Response($error, 404));
                return $error;
            }

            // Enlaza la transacción con su respectivo movimiento.
            MovimientoTransacciones::create([
                'id_movimiento_bancario' => $record->id_movimiento_bancario,
                'id_transaccion' => $transaccion->id_transaccion,
                'tipo_transaccion' => $tipo,
            ]);

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return MovimientosBancarios::where('id_movimiento_bancario', '=', $record->id_movimiento_bancario)->with(['tipo', 'cuenta.empresa', 'movimiento_transaccion.transaccion'])->first();
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
        // Define el error a mostrar
        $error = 'No se encontró el movimiento bancario que se desea eliminar';

        try {
            $item = $this->model->where('id_movimiento_bancario', '=', $id);

            if (!$item) {
                throw new HttpResponseException(new Response($error, 404));

                return $error;
            }

            DB::connection('cadeco')->beginTransaction();
            $item->delete($id);
            DB::connection('cadeco')->commit();

            // Obtener el id de los movimientos_transacciones a eliminar
            $transacciones = MovimientoTransacciones::where('id_movimiento_bancario', '=', $id)->get();

            // No existen transacciones asociadas con este movimiento.
            if (empty($transacciones)) {
                throw new HttpResponseException(new Response($error, 404));

                return $error;
            }

            foreach ($transacciones as $tr)
                Transaccion::where('id_transaccion', $tr->id_transaccion)
                    ->update(['estado' => '-2']);

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
        // Define el error a mostrar
        $error = 'No se encontró el movimiento que se desea editar';

        try {
            $item = $this->model->find($id);

            if (!$item) {
                throw new HttpResponseException(new Response($error, 404));

                return $error;
            }

            DB::connection('cadeco')->beginTransaction();
            $item->update($data);
            DB::connection('cadeco')->commit();

            // Obtener el id de las transacciones a editar
            $transacciones = MovimientoTransacciones::where('id_movimiento_bancario', '=', $id)->get();

            foreach ($transacciones as $tr)
                Transaccion::where('id_transaccion', $tr->id_transaccion)
                    ->update([
                        'fecha' => $data['fecha'],
                        'vencimiento' => $data['vencimiento'],
                        'cumplimiento' =>$data['cumplimiento'],
                        'referencia' => $data['referencia'],
                    ]);

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $this->model->with(['tipo', 'cuenta.empresa', 'movimiento_transaccion.transaccion'])->find($item->id_movimiento_bancario);
    }

    public function obras()
    {
        return Obra::all();
    }

    public function paginate(array $data)
    {
        $query = $this->model->with(['tipo', 'cuenta.empresa', 'movimiento_transaccion.transaccion']);

        foreach ($data['order'] as $order) {
            $query->orderBy($data['columns'][$order['column']]['data'], $order['dir']);
        }

        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * @param $id
     * @return \Ghi\Domain\Core\Contracts\Tesoreria\MovimientosBancariosRepository
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
}
