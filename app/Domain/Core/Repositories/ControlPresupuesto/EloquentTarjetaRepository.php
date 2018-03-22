<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 23/01/2018
 * Time: 12:37 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\TarjetaRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\Tarjeta;
use Illuminate\Support\Facades\DB;

class EloquentTarjetaRepository implements TarjetaRepository
{
    /**
     * @var Tarjeta
     */
    protected $model;

    /**
     * EloquentTarjetaRepository constructor.
     * @param Tarjeta $model
     */
    public function __construct(Tarjeta $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las Tarjetas
     * @return \Illuminate\Database\Eloquent\Collection|Tarjeta
     */
    public function all()
    {
        return $this->model->get();
    }

    public function lists()
    {
        return $this->model->lists('descripcion', 'id');
    }

    public function getAgrupacionFiltro(array $data)
    {

        $agrupacion = $this->model->select(
            DB::raw($data['columnaFiltro'] . ' as agrupador, c.precio_unitario, COUNT(1) as cantidad')
        )
            ->join('ControlPresupuesto.concepto_tarjeta as ct', 'ControlPresupuesto.tarjeta.id', '=', 'ct.id_tarjeta')
            ->join('dbo.conceptos as c', 'c.id_concepto ', '=', 'ct.id_concepto')
            ->join('PresupuestoObra.conceptosPath as cp', 'cp.id_concepto', '=', 'c.id_concepto')
            ->where('c.id_material', '=', $data['id_material'])
            ->whereIn('c.precio_unitario', $data['precios'])
            ->groupBy($data['columnaFiltro'], 'c.precio_unitario')
            ->get();
        foreach ($agrupacion as $agrupado) {
            $agrupado['aplicar_todos']=false;
            $agrupado['items']=[];

        }

        return $agrupacion;

    }

}