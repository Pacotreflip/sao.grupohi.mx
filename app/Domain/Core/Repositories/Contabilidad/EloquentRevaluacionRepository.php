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
     * @param array $array
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Obtiene el tipo de cambio del ultimo dia habil del mes en curso
     * @return float
     */
    public function getTipoCambio()
    {
        $hoy=Carbon::now();

        $cambio = Cambio::select('cambio', 'fecha')
            ->where(DB::raw("MONTH(fecha)"),'=',$hoy->month)
            ->where(DB::raw("YEAR(fecha)"),'=',$hoy->year)
            ->where('id_moneda','=',Moneda::DOLARES)
            ->whereNotIn(DB::raw("DATEPART(dw, fecha)"), [1, 7])
            ->whereRaw(DB::raw("fecha not in (SELECT fecha FROM [SEGURIDAD_ERP].[dbo].[dias_festivos])"))
            ->orderBy('fecha', 'desc')
            ->first();


        return $cambio ? $cambio->cambio : 0.0;

    }
}