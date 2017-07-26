<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 25/07/2017
 * Time: 06:45 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaMaterialRepository;
use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaMaterial;

class EloquentTipoCuentaMaterialRepository implements TipoCuentaMaterialRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Contabilidad\TipoCuentaContable
     */
    protected $model;

    /**
     * EloquentTipoCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\TipoCuentaContable $model
     */
    public function __construct(TipoCuentaMaterial $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los Tipos de Cuentas Materiales
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\TipoCuentaMaterial
     */
    public function all()
    {
        return $this->model->get();
    }
}