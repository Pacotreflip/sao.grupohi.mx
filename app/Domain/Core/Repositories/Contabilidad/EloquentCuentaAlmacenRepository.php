<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 28/06/2017
 * Time: 01:42 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaAlmacenRepository;
use Ghi\Domain\Core\Models\Contabilidad\CuentaAlmacen;


class EloquentCuentaAlmacenRepository implements CuentaAlmacenRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\CuentaAlmacen
     */
    protected $model;

    /**
     * EloquentTipoCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\CuentaAlmacen $model
     */
    public function __construct(CuentaAlmacen $model)
    {
        $this->model = $model;
    }

    /**
     * Guarda un nuevo registro de Cuenta de Almacén
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\CuentaAlmacen
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $almacen = $this->model->create([
                'cuenta' => $data['cuenta'],
                'registro' => auth()->user()->idusuario,
                'id_almacen' => $data['id_almacen']
            ]);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $almacen;
    }
}