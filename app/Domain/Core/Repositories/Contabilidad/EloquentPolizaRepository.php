<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Models\Contabilidad\CuentaContable;
use Ghi\Domain\Core\Models\Contabilidad\HistPoliza;
use Ghi\Domain\Core\Models\Contabilidad\HistPolizaMovimiento;
use Ghi\Domain\Core\Models\Contabilidad\Poliza;
use Ghi\Domain\Core\Models\Contabilidad\PolizaMovimiento;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;


class EloquentPolizaRepository implements PolizaRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Poliza
     */
    protected $model;

    /**
     * EloquentPolizaRepository constructor.
     * @param \Ghi\Domain\Core\Models\Poliza $model
     */
    public function __construct(Poliza $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las polizas
     *
     * @return \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function all()
    {
        return $this->model->toSql();
    }

    /**
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {

            DB::connection('cadeco')->beginTransaction();

            if (!$poliza = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la poliza', 404));
            }
            $poliza->concepto = $data['poliza_generada']['concepto'];

            $cuentas_debe = false;
            $cuentas_haber = false;
            $suma_debe = $data['poliza_generada']['suma_debe'];
            $suma_haber = $data['poliza_generada']['suma_haber'];
            $suma_total = $suma_debe + $suma_haber;

            if (!isset($data['poliza_generada']['poliza_movimientos'])) {
                throw new HttpResponseException(new Response('La póliza debe contener al menos un movimiento de cada tipo (Debe, Haber)', 404));
            }

            foreach ($data['poliza_generada']['poliza_movimientos'] as $polizaMovimiento) {
                $repetido = 0;
                if ($polizaMovimiento['id_tipo_movimiento_poliza'] == 1) {
                    $cuentas_debe = true;
                }
                if ($polizaMovimiento['id_tipo_movimiento_poliza'] == 2) {
                    $cuentas_haber = true;
                }

                $tipoCuentaContable = CuentaContable::where('cuenta_contable', '=', $polizaMovimiento['cuenta_contable']);
                if (!$tipoCuentaContable) {
                    throw new HttpResponseException(new Response('No se encontró la Cuenta Contable.', 404));
                }
                foreach ($data['poliza_generada']['poliza_movimientos'] as $movimiento_aux) {
                    if ($polizaMovimiento['cuenta_contable'] == $movimiento_aux['cuenta_contable']) {
                        $repetido++;
                    }
                }
                if ($repetido > 1) {
                    throw new HttpResponseException(new Response('Existe una cuenta repetida en los movimientos', 404));
                }

            }

            if (!$cuentas_debe || !$cuentas_haber) {
                throw new HttpResponseException(new Response('La póliza debe contener al menos un movimiento de cada tipo (Debe, Haber)', 404));
            }
            if ($suma_debe != $suma_haber) {
                throw new HttpResponseException(new Response('Las sumas iguales no corresponden.', 404));
            }
            if (number_format($suma_debe,2) != number_format($data['poliza_generada']['total'], 2) ||number_format($suma_haber,2) != number_format($data['poliza_generada']['total'], 2)) {
                throw new HttpResponseException(new Response(
                    'Las sumas iguales deben ser iguales a $' . number_format($data['poliza_generada']['total'], 2, '.', ','), 404));
            }

            $movimientos_actuales = PolizaMovimiento::where('id_int_poliza', $poliza->id_int_poliza)->get();

            foreach ($movimientos_actuales as $polizaMovimiento) {
                $polizaMovimiento->delete();
            }


            foreach ($data['poliza_generada']['poliza_movimientos'] as $polizaMovimiento) {
                if (count($polizaMovimiento) > 10) {
                    $movimientoPoliza = PolizaMovimiento::withTrashed()->find($polizaMovimiento['id_int_poliza_movimiento']);
                    $movimientoPoliza->referencia = $polizaMovimiento['referencia'];
                    $movimientoPoliza->concepto = $polizaMovimiento['concepto'];
                    $movimientoPoliza->cuenta_contable = $polizaMovimiento['cuenta_contable'];
                    $movimientoPoliza->importe = $polizaMovimiento['importe'];
                    $movimientoPoliza->id_tipo_movimiento_poliza = $polizaMovimiento['id_tipo_movimiento_poliza'];
                    $movimientoPoliza->id_tipo_cuenta_contable = $polizaMovimiento['id_tipo_cuenta_contable'];
                    $movimientoPoliza->estatus = $polizaMovimiento['estatus'];
                    $movimientoPoliza->restore();

                } else {
                    $movimientoPoliza = new PolizaMovimiento();
                    $movimientoPoliza->id_int_poliza = $poliza->id_int_poliza;
                    $movimientoPoliza->referencia = $polizaMovimiento['referencia'];
                    $movimientoPoliza->concepto = $polizaMovimiento['concepto'];
                    $movimientoPoliza->cuenta_contable = $polizaMovimiento['cuenta_contable'];
                    $movimientoPoliza->importe = $polizaMovimiento['importe'];
                    $movimientoPoliza->id_tipo_movimiento_poliza = $polizaMovimiento['id_tipo_movimiento_poliza'];
                    $movimientoPoliza->id_tipo_cuenta_contable = $polizaMovimiento['id_tipo_cuenta_contable'];
                    $movimientoPoliza->estatus = $polizaMovimiento['estatus'];

                    $movimientoPoliza->save();
                }

            }

            $poliza->estatus = 0;
            $poliza->save();
            $poliza = $this->model->find($id);
            $poliza_hist = HistPoliza::create($poliza->toArray());
            foreach ($poliza->polizaMovimientos as $movimiento) {
                $movimiento->id_hist_int_poliza = $poliza_hist->id_hist_int_poliza;
                $hist_movimiento = HistPolizaMovimiento::create($movimiento->toArray());
            }

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
        return $this->find($id, ['polizaMovimientos', 'tipoPolizaContpaq']);
    }


    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Paginador
     * @param $perPage
     * @return mixed
     */
    public function paginate($perPage)
    {
        return $this->model->paginate($perPage);
    }

    public function where(array $where)
    {
        $this->model = $this->model->where($where);
        return $this;
    }


    /**
     * @param $array
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function findWhereIn($array){
       return  $this->model->find($array);
      }

    public function scope($scope)
    {
        $this->model = $this->model->$scope();
        return $this;
    }
}