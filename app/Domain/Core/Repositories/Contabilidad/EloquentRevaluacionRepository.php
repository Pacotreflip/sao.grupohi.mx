<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Carbon\Carbon;
use Ghi\Domain\Core\Contracts\Contabilidad\RevaluacionRepository;
use Ghi\Domain\Core\Models\Cambio;
use Ghi\Domain\Core\Models\Contabilidad\Revaluacion;
use Ghi\Domain\Core\Models\Moneda;
use Ghi\Domain\Core\Models\Seguridad\DiaFestivo;
use Illuminate\Support\Facades\DB;

class EloquentRevaluacionRepository implements RevaluacionRepository
{

    /**
     * @var Revaluacion
     */
    protected $model;

    /**
     * EloquentRevaluacionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Contabilidad\Revaluacion $model
     */
    public function __construct(Revaluacion $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las revaluacion
     * @return \Illuminate\Database\Eloquent\Collection | \Ghi\Domain\Core\Contracts\Contabilidad\Revaluacion
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Guarda un registro de Revaluacion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\Revaluacion
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $item = $this->model->create($data);
            foreach ($data['id_transaccion'] as $key => $value) {
              $item->facturas()->attach($key);
            }
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $item;
    }

    /**
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\Revaluacion
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    private function getPrimerDiaRevaluacion($month) {
        $ultimo_dia_mes=new Carbon("last day of {$month} month", 'America/Mexico_City');

        $ultimo_dia_habil = null;

        for ($i = 1; $i < 31; $i++) {
             $es_habil=DB::connection('seguridad')
                 ->select(DB::raw("SELECT IIF('{$ultimo_dia_mes}' not in (SELECT fecha FROM [SEGURIDAD_ERP].[dbo].[dias_festivos]) and DATEPART(dw, '{$ultimo_dia_mes}')  not in (1,7) , 1, 0) as es_habil"));
             if((bool) $es_habil[0]->es_habil) {
                 $ultimo_dia_habil = $ultimo_dia_mes;
                 break;
             } else {
                 $ultimo_dia_mes->subDay();
             }
        }
        return $ultimo_dia_habil;

    }

    private function getUltimoDiaRevaluacion($month) {
        $primer_dia_revaluacion = new Carbon("last day of {$month} month", 'America/Mexico_city');
        $ultimo_dia_revaluacion = null;

        $i = 1;
        while($i < 4) {
            $primer_dia_revaluacion->addDay();
            $es_habil = DB::connection('seguridad')
                ->select(DB::raw("SELECT IIF('{$primer_dia_revaluacion}' not in (SELECT fecha FROM [SEGURIDAD_ERP].[dbo].[dias_festivos]) and DATEPART(dw, '{$primer_dia_revaluacion}')  not in (1,7) , 1, 0) as es_habil"));
            if((bool) $es_habil[0]->es_habil) {
                $i++;
            }
        }
        return  $primer_dia_revaluacion;
    }

    /**
     * Obtiene el tipo de cambio del ultimo dia habil del mes en curso
     * @return float
     */
    public function getTipoCambio()
    {
        $hoy = Carbon::now();
        if($hoy->between($this->getPrimerDiaRevaluacion('last'), $this->getUltimoDiaRevaluacion('last'))) {
            $hoy->subMonth();
        }

        $cambio = Cambio::select('cambio', 'fecha')
            ->where(DB::raw("MONTH(fecha)"), '=' , $hoy->month)
            ->where(DB::raw("YEAR(fecha)"), '=' ,$hoy->year)
            ->where('id_moneda', '=' , Moneda::DOLARES)
            ->whereNotIn(DB::raw("DATEPART(dw, fecha)"), [1, 7])
            ->whereRaw(DB::raw("fecha not in (SELECT fecha FROM [SEGURIDAD_ERP].[dbo].[dias_festivos])"))
            ->orderBy('fecha', 'DESC')
            ->first();

        return $cambio ? $cambio->cambio : 0.0;
    }

    public function esRevaluable()
    {
        $hoy = Carbon::now();
        if ($hoy->between($this->getPrimerDiaRevaluacion('this'), $this->getUltimoDiaRevaluacion('this'))) {
            return true;
        } else if ($hoy->between($this->getPrimerDiaRevaluacion('last'), $this->getUltimoDiaRevaluacion('last'))) {
            return true;
        } else {
            return false;
        }
    }

    public function getFechaRevaluacion()
    {
        $hoy = Carbon::now();
        if ($hoy->between($this->getPrimerDiaRevaluacion('last'), $this->getUltimoDiaRevaluacion('last'))) {
            $hoy->subMonth();
        }
        return $hoy;
    }
}