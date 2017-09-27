<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 27/07/2017
 * Time: 02:09 PM
 */

namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\SubcontratoRepository;
use Ghi\Domain\Core\Models\Transacciones\Subcontrato;
use Illuminate\Database\Eloquent\Collection;

class EloquentSubcontratoRepository implements SubcontratoRepository
{
    /**
     * @var Subcontrato
     */
    protected $model;

    /**
     * EloquentSubcontratoRepository constructor.
     * @param Subcontrato $model
     */
    public function __construct(Subcontrato $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene los Subcontratos que coincidan con los campos de búsqueda
     * @param $attribute
     * @param $operator
     * @param $value
     * @return Collection
     */
    public function getBy($attribute, $operator, $value)
    {
        return $this->model->where($attribute, $operator, $value)->get();
    }
}