<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\PolizaHistoricoRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Models\Contabilidad\HistPoliza;
use Ghi\Domain\Core\Models\Contabilidad\HistPolizaMovimiento;
use Ghi\Domain\Core\Models\Contabilidad\Poliza;


class EloquentPolizaHistoricoRepository implements PolizaHistoricoRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Poliza
     */
    protected $model;

    /**
     * EloquentPolizaRepository constructor.
     * @param \Ghi\Domain\Core\Models\Poliza $model
     */
    public function __construct(HistPoliza $model)
    {
        $this->model = $model;
    }


    /**
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function find($id)
    {
        return $model = $this->model->where('id_int_poliza', '=', $id)->orderBy('created_at','Desc')->get();
    }

}