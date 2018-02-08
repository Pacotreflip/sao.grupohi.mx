<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Carbon\Carbon;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Models\Contabilidad\CuentaContable;
use Ghi\Domain\Core\Models\Contabilidad\EstatusPrePoliza;
use Ghi\Domain\Core\Models\Contabilidad\HistPoliza;
use Ghi\Domain\Core\Models\Contabilidad\HistPolizaMovimiento;
use Ghi\Domain\Core\Models\Contabilidad\Poliza;
use Ghi\Domain\Core\Models\Contabilidad\PolizaMovimiento;
use Ghi\Domain\Core\Models\Contabilidad\PolizaValido;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Ghi\Domain\Core\Models\User;


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
        return $this->model->get();
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
                throw new HttpResponseException(new Response('No se encontró la prepóliza', 404));
            }

            if($poliza->estatus == 1 || $poliza->estatus == 2 ) {
                throw new HttpResponseException(new Response('No se puede editar la prepóliza ya que su estatus es '.  $poliza->estatusPrepoliza , 404));
            }

            if (isset($data['poliza_generada']['fecha'])) {
                $poliza->update([
                    'fecha_original' => $poliza->fecha,
                    'fecha' => $data['poliza_generada']['fecha']
                ]);
            }

            if(isset($data['poliza_generada']['poliza_movimientos'])) {
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


                }




                if (!$cuentas_debe || !$cuentas_haber) {
                    throw new HttpResponseException(new Response('La póliza debe contener al menos un movimiento de cada tipo (Debe, Haber)', 404));
                }
                if (abs($suma_debe-$suma_haber)>.99) {
                    throw new HttpResponseException(new Response('Las sumas iguales no corresponden.', 404));
                }
                /*if (abs($data['poliza_generada']['total'] - $suma_haber) > .99 || abs($data['poliza_generada']['total'] - $suma_debe) > .99) {
                    throw new HttpResponseException(new Response(
                        'Las sumas iguales deben ser iguales a $' . number_format($data['poliza_generada']['total'], 2, '.', ','), 404));
                }*/


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
                        $movimientoPoliza->estatus = 1;
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
                        $movimientoPoliza->estatus = 1;

                        $movimientoPoliza->save();
                    }

                }

                $poliza->concepto = $data['poliza_generada']['concepto'];
                $poliza->estatus = 0;
                $poliza->cuadre = $suma_debe-$suma_haber;
                $poliza->total = $suma_debe > $suma_haber ? $suma_debe : $suma_haber;

                $poliza->save();
                $poliza = $this->model->find($id);
                $fecha=Carbon::parse($poliza->fecha)->format('Y-m-d H:i:s');

                $polizaArray=$poliza->toArray();
                $polizaArray['fecha']=$fecha;
                $poliza_hist = HistPoliza::create($polizaArray);
                foreach ($poliza->polizaMovimientos as $movimiento) {
                    $movimiento->id_hist_int_poliza = $poliza_hist->id_hist_int_poliza;
                    $hist_movimiento = HistPolizaMovimiento::create($movimiento->toArray());
                }
            } else {

                // Registra quién validó
                if (isset($data['poliza_generada']['estatus']) && $data['poliza_generada']['estatus'] == 1 )
                    PolizaValido::create([
                        'id_int_poliza' => $poliza->id_int_poliza,
                        'valido' => auth()->user()->idusuario,
                    ]);

                $poliza->update($data['poliza_generada']);
            }

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
        return $this->find($id);
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
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data)
    {
        $query = $this->model
            ->join(DB::raw('Contabilidad.estatus_prepolizas as estatus_prepoliza'), 'Contabilidad.int_polizas.estatus', '=', 'estatus_prepoliza.estatus')
            ->join(DB::raw('Contabilidad.int_tipos_polizas_contpaq as tipo_poliza_contpaq'), 'Contabilidad.int_polizas.id_tipo_poliza_contpaq', '=', 'tipo_poliza_contpaq.id_int_tipo_poliza_contpaq')
            ->join(DB::raw('Contabilidad.int_transacciones_interfaz as transaccion_interfaz'), 'Contabilidad.int_polizas.id_tipo_poliza_interfaz', '=', 'transaccion_interfaz.id_transaccion_interfaz');

        $query->where(function ($query) use ($data) {
            $query->where('estatus_prepoliza.descripcion', 'like', '%'.$data['search']['value'].'%')
                ->orWhere('tipo_poliza_contpaq.descripcion', 'like', '%'.$data['search']['value'].'%')
                ->orWhere('transaccion_interfaz.descripcion', 'like', '%'.$data['search']['value'].'%')
                ->orWhere('concepto', 'like', '%'.$data['search']['value'].'%')
                ->orWhere('fecha', 'like', '%'.$data['search']['value'].'%')
                ->orWhere('total', 'like', '%'.$data['search']['value'].'%')
                ->orWhere('cuadre', 'like', '%'.$data['search']['value'].'%')
                ->orWhere('poliza_contpaq', 'like', '%'.$data['search']['value'].'%');
        });

        foreach ($data['order'] as $order) {
            $query->orderBy($data['columns'][$order['column']]['data'], $order['dir']);
        }

        $query->select('Contabilidad.int_polizas.*');

        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
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


    /**
     * recupera un array con los últimos 7 diasa partir de la fecha
     * actual
     * @return mixed
     *
     */
    public function getDates()
    {
        $fechas = [];
        $hoy = Carbon::now();
        $pasado = Carbon::now()->subDays(7);


        for($date = $pasado; $date->lte($hoy); $date->addDay()) {
            $fechas[] = $date->format('Y/m/d');
        }

        return $fechas;
    }

    /**
     * Obtiene los datos para las estadisticas iniciales
     * @return mixed
     *
     */
    public function getChartInfo()
    {
        $fechas = $this->getDates();

        $config = [
            'labels' => $fechas,
            'datasets' => []
        ];

        foreach (EstatusPrePoliza::all() as $estatus) {
            $d = [];
            $resp = collect( DB::connection('cadeco')->table('Contabilidad.int_polizas')->select(DB::raw("FORMAT(fecha, 'yyyy/MM/dd') as fecha_"), DB::raw(" COUNT(*) AS count"))
                    ->whereBetween('Contabilidad.int_polizas.fecha', [$fechas[0], $fechas[count($fechas)-1]])
                    ->where('Contabilidad.int_polizas.estatus', '=', $estatus->estatus)
                    ->groupBy('Contabilidad.int_polizas.fecha')->get());

            if(count($resp) > 0) {
                for ($i = 0; $i < count($fechas); $i++) {
                    foreach ($resp as $r){
                        if ($fechas[$i] == $r->fecha_){
                            $d[$i] = $r->count;
                            break;
                        }
                        $d[$i] = 0;
                    }
                }
            } else {
                for ($j = 0; $j < count($fechas); $j++) {
                    $d[$j] = 0;
                }
            }

            array_push($config['datasets'], [
                'label' => $estatus->descripcion,
                'backgroundColor' => $estatus->rgb,
                'borderColor' => $estatus->rgb,
                'data' => $d,
                'fill' => false
            ]);
        }
        return $config;
    }

    /**
     * Retorna el conteo de cada tipo de poliza por fecha ingresada
     * @return mixed
     */
    public function getCountDate($date, $tipo)
    {

        return $this->model->where('fecha', '=', $date)
                    ->where('estatus', '=', $tipo)->count();
    }

    /**
     * Ingresa manualmente el folio contpaq para la prepóliza
     * @param $data
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function ingresarFolio($data, $id)
    {
        try {

            DB::connection('cadeco')->beginTransaction();

            if (!$poliza = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la prepóliza', 404));
            }

            if($poliza->estatus == 1 || $poliza->estatus == 2 ) {
                throw new HttpResponseException(new Response('No se puede editar la prepóliza ya que su estatus es '.  $poliza->estatusPrepoliza , 404));
            }

            $poliza->update([
                'estatus' => 3,
                'fecha_original' => $poliza->fecha
            ]);

            $poliza->update($data);


            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
        return $this->find($id);
    }
}