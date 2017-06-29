<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 29/06/2017
 * Time: 11:12 AM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaEmpresaRepository;
use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaEmpresa;

class EloquentTipoCuentaEmpresaRepository implements TipoCuentaEmpresaRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\TipoCuentaEmpresa
     */
    protected $model;

    /**
     * EloquentTipoCuentaEmpresaRepository constructor.
     * @param \Ghi\Domain\Core\Models\TipoCuentaEmpresa $model
     */
    public function __construct(TipoCuentaEmpresa $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los tipos de Cuenta en empresa
     *
     * @return \Illuminate\Database\Eloquent\Collection|TipoCuentaEmpresa
     */
    public function all()
    {
     return $this->model->all();
    }
}