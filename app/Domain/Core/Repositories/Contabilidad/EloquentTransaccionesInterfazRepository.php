<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 19/07/2017
 * Time: 01:43 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


use Ghi\Domain\Core\Contracts\Contabilidad\TransaccionesInterfazRepository;
use Ghi\Domain\Core\Models\Contabilidad\TransaccionInterfaz;

class EloquentTransaccionesInterfazRepository implements TransaccionesInterfazRepository
{
    /**
     * @var PolizaTipoSAO $model
     */
    private $model;

    /**
     * EloquentTransaccionesInterfazRepository constructor.
     * @param TransaccionInterfaz $model
     */
    public function __construct(TransaccionInterfaz $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Contabilidad\TransaccionInterfaz
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Obtienes las trnsacciones sao en lista para combo
     * @return array
     */
    public function lists()
    {
        return $this->model->orderBy('descripcion', 'ASC')->lists('descripcion', 'id_transaccion_interfaz');
    }

}