<?php

namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\PolizaHistoricoRepository;
use Ghi\Domain\Core\Contracts\PolizaRepository;
use Ghi\Domain\Core\Models\HistPoliza;
use Ghi\Domain\Core\Models\HistPolizaMovimiento;
use Ghi\Domain\Core\Models\Poliza;


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