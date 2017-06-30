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
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class EloquentCuentaAlmacenRepository implements CuentaAlmacenRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\CuentaAlmacen
     */
    protected $model;

    /**
     * EloquentTipoCuentaContableRepository constructor.
     * @param CuentaAlmacen|\Ghi\Domain\Core\Models\CuentaAlmacen $model
     */

    public function __construct(CuentaAlmacen $model)
    {
        $this->model = $model;
    }

    /**
     * Guarda un registro de cuenta almacén
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaAlmacen
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $data['registro'] = auth()->user()->idusuario;
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
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaAlmacen
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
                'id_almacen' => $old->id_almacen,
                'cuenta' => $data['cuenta'],
                'registro' => auth()->user()->idusuario
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