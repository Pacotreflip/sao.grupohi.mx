<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 10/07/2017
 * Time: 06:49 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaMaterialRepository;
use Ghi\Domain\Core\Models\Contabilidad\CuentaMaterial;
use Illuminate\Support\Facades\DB;


class EloquentCuentaMaterialRepository implements CuentaMaterialRepository
{
    protected $model;

    /**
     * EloquentTipoCuentaContableRepository constructor.
     * @param CuentaAlmacen|\Ghi\Domain\Core\Models\CuentaAlmacen $model
     */

    public function __construct(CuentaMaterial $model)
    {
        $this->model = $model;
    }

    /**
     * Guarda un registro de cuenta almacén
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaMaterial
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $data['registro'] = auth()->user()->idusuario;
            $data['id_obra'] = Context::getId();
            $item = $this->model->create($data);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $item;
    }

    /**
     * Actualiza un registro de cuenta almacén
     * @param array $data
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaMaterial
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            if (! $old = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la Cuenta del Almacén que se desea Actualizar', 404));
            }

            if($old->cuenta == $data['cuenta']) {
                throw new HttpResponseException(new Response('La cuenta de Almacén que intentas actualizar es la misma', 404));
            }

            $new = $this->model->create([
                'id_material' => $old->id_material,
                'cuenta' => $data['cuenta'],
                'id_tipo_cuenta_material' => $data['id_tipo_cuenta_material'],
                'registro' => auth()->user()->idusuario,
                'id_obra' => Context::getId()
            ]);

            $old->update(['estatus' => 0]);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $new;
    }
}