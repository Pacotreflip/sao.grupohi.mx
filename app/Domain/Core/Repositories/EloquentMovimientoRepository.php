<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\MovimientoRepository;
use Ghi\Domain\Core\Models\MovimientoPoliza;

class EloquentMovimientoRepository implements MovimientoRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\MovimientoPoliza
     */
    private $model;

    /**
     * EloquentMovimientoRepository constructor.
     * @param \Ghi\Domain\Core\Models\MovimientoPoliza $model
     */
    public function __construct(MovimientoPoliza $model)
    {
        $this->model = $model;
    }

    /**
     * Crea un nuevo registro de Movimiento
     * @param $data
     * @return \Ghi\Domain\Core\Models\MovimientoPoliza
     */
    public function create($data)
    {
        $this->model->create([
            'id_poliza_tipo' => $data['id_poliza_tipo'],
            'id_cuenta_contable' => $data['id_cuenta_contable'],
            'id_tipo_movimiento' => $data['id_tipo_movimiento'],
            'registro' => auth()->user()->idusuario
        ]);
    }

    /**
     * Obtiene los movimientos que coindican con la busqueda
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->get($columns);
    }
}