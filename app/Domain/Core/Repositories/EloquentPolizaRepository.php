<?php

namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\PolizaRepository;
use Ghi\Domain\Core\Models\CuentaContable;
use Ghi\Domain\Core\Models\HistPoliza;
use Ghi\Domain\Core\Models\HistPolizaMovimiento;
use Ghi\Domain\Core\Models\Poliza;
use Ghi\Domain\Core\Models\PolizaMovimiento;
use Ghi\Domain\Core\Models\TipoCuentaContable;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
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
    public function all($with = null)
    {
        if ($with != null) {
            return $this->model->with($with)->get();
        }
        return $this->model->all();
    }

    /**
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function find($id, $with = null)
    {
        if ($with != null) {
            return $this->model->with($with)->find($id);
        }

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

            $cuentas_debe = false;
            $cuentas_haber = false;
            $suma_debe = $data['poliza_generada']['suma_debe'];
            $suma_haber = $data['poliza_generada']['suma_haber'];
            $suma_total = $suma_debe + $suma_haber;

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
            if ($suma_total!=$data['poliza_generada']['total']) {
                throw new HttpResponseException(new Response('Las sumas iguales no deben exceder $' . $data['poliza_generada']['total'], 404));
            }




            foreach ($data['poliza_generada']['poliza_movimientos'] as $polizaMovimiento) {
                if ($polizaMovimiento['id_int_poliza_movimiento'] != null) {
                    PolizaMovimiento::update($polizaMovimiento);
                } else {
                    PolizaMovimiento::create($polizaMovimiento);
                }
            }
            Poliza::update($data['poliza_generada']);
            /*

                    DB::connection('cadeco')->beginTransaction();
                    $poliza = $this->model->find($id);
                    $poliza_hist = HistPoliza::create($poliza->toArray());
                    foreach ($poliza->polizaMovimientos as $movimiento) {
                        $movimiento->id_hist_int_poliza=$poliza_hist->id_hist_int_poliza;
                        $hist_movimiento = HistPolizaMovimiento::create($movimiento->toArray());
                    }

        */
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
        return $this->model->find($id);

    }
}