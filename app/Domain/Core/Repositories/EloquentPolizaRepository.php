<?php

namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\PolizaRepository;
use Ghi\Domain\Core\Models\CuentaContable;
use Ghi\Domain\Core\Models\HistPoliza;
use Ghi\Domain\Core\Models\HistPolizaMovimiento;
use Ghi\Domain\Core\Models\Poliza;
use Ghi\Domain\Core\Models\TipoCuentaContable;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;


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

            foreach ($data['movimientos'] as $movimiento) {
                $repetido = 0;
                $tipoCuentaContable = CuentaContable::where('cuenta_contable', '=', $movimiento->cuenta_contable);
                if (!$tipoCuentaContable) {
                    throw new HttpResponseException(new Response('No se encontró la Cuenta Contable.', 404));
                }
                foreach ($data['movimientos'] as $movimiento_aux) {
                    if ($movimiento->cuenta_contable == $movimiento_aux->cuenta_contable) {
                        $repetido++;
                    }
                }
                if ($repetido > 1) {
                    throw new HttpResponseException(new Response('Existe una cuenta repetida en los movimientos', 404));
                }

            }

            if ($this->model->SumaDebe != $this->model->SumaHaber) {
                throw new HttpResponseException(new Response('Las sumas iguales no corresponden.', 404));
            }


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