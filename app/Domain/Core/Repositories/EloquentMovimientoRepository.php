<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\MovimientoRepository;
use Ghi\Domain\Core\Models\MovimientoPoliza;
use Mockery\Exception;

class EloquentMovimientoRepository implements MovimientoRepository
{

    /**
     * @var MovimientoPoliza
     */
    private $model;

    /**
     * EloquentMovimientoRepository constructor.
     */
    public function __construct(MovimientoPoliza $model)
    {
        $this->model = $model;
    }

    function create(array $data)
    {
        $this->model->create([
            'id_poliza_tipo'=>$data['id_poliza_tipo'],
            'id_cuenta_contable'=>$data['id_cuenta_contable'],
            'id_tipo_movimiento'=>$data['id_tipo_movimiento'],
            'registro' => auth()->user()->idusuario
        ]);
    }

    public function getByPolizaTipoId($id)
    {
        return $this->model->where('id_poliza_tipo', '=', $id)->get();
    }
}