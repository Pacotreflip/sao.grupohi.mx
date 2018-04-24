<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 28/12/2017
 * Time: 06:54 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Contracts\TipoTranRepository;
use Ghi\Domain\Core\Models\User;
use Illuminate\Support\Facades\DB;

class EloquentTipoTranRepository implements TipoTranRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\TipoTransaccion
     */
    private $model;

    /**
     * EloquentTipoTranRepository constructor.
     * @param \Ghi\Domain\Core\Models\TipoTransaccion $model
     */
    public function __construct(\Ghi\Domain\Core\Models\TipoTransaccion $model)
    {
        $this->model = $model;
    }


    /**
     * Obtienes los tipos de transacción en lista para combo
     * @return array
     */
    public function lists()
    {
        return $this->model->orderBy('descripcion')->lists('Descripcion as id', 'Descripcion');
    }

    /**
     * @param array $orWhere
     * @return mixed
     */
    public function orWhere(array $orWhere)
    {
        $m = DB::connection('cadeco')->table('dbo.TipoTran');
        foreach ($orWhere as $where) {
            $m
                ->orWhere(function ($query) use ($where) {
                    foreach ($where as $column => $value) {
                        $query->where($column, $value);
                    }
                });
        }
        return $m->get();
    }

}