<?php

namespace Ghi\Domain\Core\Repositories\Tesoreria;

use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Contracts\Tesoreria\TraspasoCuentasRepository;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoCuentas;
use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoTransaccion;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Domain\Core\Models\Obra;

class EloquentTraspasoCuentasRepository implements TraspasoCuentasRepository
{
    /**
     * @var TraspasoCuentas $model
     */
    private $model;
    /**
     * @var Cuentas $cuenta
     */
    private $cuenta;

    /**
     * EloquentTraspasoCuentasRepository constructor.
     * @param TransaccionInterfaz $model
     */
    public function __construct(TraspasoCuentas $model)
    {
        $this->model = $model;
        $this->cuentas = new Cuenta;
        $this->traspaso_transaccion = new TraspasoTransaccion;
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
        $obras = $this->obras();
        $id_obra = session()->get('id');
        $id_moneda = 0;

        foreach ($obras as $o)
            if ($o->id_obra == $id_obra)
                $id_moneda = $o->id_moneda;

        try {
            DB::connection('cadeco')->beginTransaction();
            $record = $this->model->create($data);
            DB::connection('cadeco')->commit();

            $credito = [
                'tipo_transaccion' => 83,
                'fecha' => $data['fecha'] ? $data['fecha'] : date('Y-m-d'),
                'estado' => 1,
                'id_obra' => $id_obra,
                'id_cuenta' => $data['id_cuenta_destino'],
                'id_moneda' => $id_moneda,
                'cumplimiento' => $data['cumplimiento'] ? $data['cumplimiento'] : date('Y-m-d'),
                'vencimiento' => $data['vencimiento'] ? $data['vencimiento'] : date('Y-m-d'),
                'opciones' => 1,
                'monto' => $data['importe'],
                'impuesto' => 0,
                'referencia' => $data['referencia'],
                'comentario' => "I;". date("d/m/Y") ." ". date("h:s") .";". auth()->user()->usuario,
                'observaciones' => $data['observaciones'],
                'FechaHoraRegistro' => date('Y-m-d h:i:s'),
            ];

            $debito = $credito;
            $debito['tipo_transaccion'] = 84;
            $debito['id_cuenta'] = $data['id_cuenta_origen'];
            $debito['monto'] = (float)  ($data['importe'] * -1);

            // Crear transaccion Débito
            $transaccion_debito = Transaccion::create($debito);

            // Crear transaccion Crédito
            $transaccion_credito = Transaccion::create($credito);

            // Revisa si la transacción se realizó
            $debito_realizo = Transaccion::where('id_transaccion', $transaccion_debito->id_transaccion)->first();
            $credito_realizo = Transaccion::where('id_transaccion', $transaccion_credito->id_transaccion)->first();

            // Si alguna de las transacciones no se registró, regresa un error
            if (!$debito_realizo || !$credito_realizo)
            {
                DB::connection('cadeco')->rollBack();

                return 'El traspaso no se pudo concretar';
            }

            // Enlaza las transacciones con su respectivo traspaso. Debito
            TraspasoTransaccion::create([
                'id_traspaso' => $record->id_traspaso,
                'id_transaccion' => $transaccion_debito->id_transaccion,
                'tipo_transaccion' => $debito['tipo_transaccion'],
            ]);

            // Enlaza las transacciones con su respectivo traspaso. Credito
            TraspasoTransaccion::create([
                'id_traspaso' => $record->id_traspaso,
                'id_transaccion' => $transaccion_credito->id_transaccion,
                'tipo_transaccion' => $credito['tipo_transaccion'],
            ]);

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return TraspasoCuentas::where('id_traspaso', '=', $record->id_traspaso)->with(['cuenta_destino.empresa', 'cuenta_origen.empresa', 'traspaso_transaccion.transaccion_debito'])->first();
    }

    public function regresaTraspaso($id)
    {

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

            $item = $this->model->where('id_traspaso', '=', $id);

            if (!$item) {
                throw new HttpResponseException(new Response('No se encontró el traspaso que se desea eliminar', 404));
            }

            $item->delete($id);

            // Obtener el id de las transacciones a eliminar
            $transacciones = TraspasoTransaccion::where('id_traspaso', '=', $id)->get();

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
     *  Edita el tipo de traspaso entre cuentas seleccionado
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
                throw new HttpResponseException(new Response('No se encontró el traspaso que se desea eliminar', 404));
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
