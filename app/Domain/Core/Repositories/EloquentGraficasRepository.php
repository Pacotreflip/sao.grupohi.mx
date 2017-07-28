<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 27/07/2017
 * Time: 02:09 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Contracts\GraficasRepository;
use Ghi\Domain\Core\Models\Almacen;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Contabilidad\CuentaAlmacen;
use Ghi\Domain\Core\Models\Contabilidad\EstatusPrePoliza;
use Ghi\Domain\Core\Models\Contabilidad\Poliza;
use Carbon\Carbon;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Material;
use Illuminate\Support\Facades\DB;

class EloquentGraficasRepository implements GraficasRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Poliza
     */
    protected $poliza_model;

    /**
     * EloquentPolizaRepository constructor.
     * @param \Ghi\Domain\Core\Models\Poliza $model
     */
    public function __construct(Poliza $model)
    {
        $this->poliza_model = $model;
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
     * Retorna el acumilado de Polizas Tipo de acuerdo al total por estatus
     * @return mixed
     */
    public function getChartAcumuladoInfo()
    {
        $labels=[];
        $data = [];
        $backgroundColor = [];
        $estatus=[];

        $acumulado = $this->poliza_model->select(DB::raw(" COUNT(*) AS count"), 'estatus')->groupBy('estatus')->get();

        foreach (EstatusPrePoliza::all() as $status) {
            for($i = 0; $i < count($acumulado); $i++){
                if($acumulado[$i]->estatus == $status->estatus){
                    $labels[] = $status->descripcion;
                    $data[] = $acumulado[$i]->count;
                    $backgroundColor[] = $status->rgb;
                    $estatus[] = $status->estatus;
                    break;
                }
            }
        }

        $acum = [
            'labels' => $labels,
            'estatus'=> $estatus,
            'datasets' => [[
                'data'=> $data,
                'backgroundColor'=> $backgroundColor
            ]]
        ];
        return $acum;
    }

    /**
     * Regresa los datos para el Chart informativo de Cuentas Contables
     * @return mixed
     */
    public function getChartCuentaContableInfo()
    {
        $cuentas = [
            'labels'=> ["Almacenes", "Conceptos", "Empresas", "Materiales"],
            'datasets'=> [[
                    'label'           => '% Con Cuenta Contable',
                    'backgroundColor' => 'rgb(75, 192, 192)',
                    'data'            => [
                        number_format((Almacen::has('cuentaAlmacen')->count() * 100) / Almacen::count(), 2),
                        number_format((Concepto::has('cuentaConcepto')->count() * 100) / Concepto::count(), 2),
                        number_format((Empresa::has('cuentasEmpresa')->count() * 100) / Empresa::count(),2),
                        number_format((Material::has('cuentaMaterial')->count() * 100) / Material::count(),2),
                    ]
                ],[
                    'label'           => '% Sin Cuenta Contable',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'data'            => [
                        number_format((Almacen::has('cuentaAlmacen', '=', 0)->count() * 100) / Almacen::count(),2),
                        number_format((Concepto::has('cuentaConcepto', '=', 0)->count() * 100) / Concepto::count(),2),
                        number_format((Empresa::has('cuentasEmpresa', '=', 0)->count() * 100) / Empresa::count(),2),
                        number_format((Material::has('cuentaMaterial', '=', 0)->count() * 100) / Material::count(),2),
                    ]
                ]
            ]
        ];

        return $cuentas;
    }
}