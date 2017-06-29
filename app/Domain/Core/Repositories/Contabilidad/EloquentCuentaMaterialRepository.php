<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 26/06/2017
 * Time: 11:06 AM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaMaterialRepository;
use Ghi\Domain\Core\Contracts\Identificador;
use Ghi\Domain\Core\Contracts\Motivo;
use Ghi\Domain\Core\Models\Material;


class EloquentCuentaMaterialRepository implements CuentaMaterialRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\CuentaMaterial
     */
    protected $model;

    /**
     * EloquentTipoCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\TipoCuentaContable $model
     */
    public function __construct(Material $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las Cuentas de Materiales
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\CuentaMaterial
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     *  Obtiene Cuenta de Material por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaMaterial
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Guarda un nuevo registro de Cuenta Material
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\CuentaMaterial
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $cuenta_material = $this->model->create([
                //'descripcion' => $data['descripcion'],
                //'registro' => auth()->user()->idusuario,
                //'id_obra' => Context::getId()
            ]);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $cuenta_material;
    }

    /**
     * Aplica un SoftDelete a la Cuenta de Material seleccionado
     * @param $data Motivo por el cual se elimina el registro
     * @param $id Identificador del registro de al Cuenta de Material que se va a eliminar
     * @return mixed
     * @throws \Exception
     */
    public function delete($data, $id)
    {
        try {
        DB::connection('cadeco')->beginTransaction();

        if (!$item = $this->model->find($id)) {
            throw new HttpResponseException(new Response('No se encontró la plantilla que se desea eliminar', 404));
        }

        $item->update($data);
        $item->delete($id);

        DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
    }

    /**
     * Obtiene todas las Cuentas de Materiales padre
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\CuentaMaterial
     */
    public function lista($value)
    {
        $resp = Material::where('tipo_material', $value)
            ->where(DB::raw('SUBSTRING(nivel, 5,1)'), '=','')
            ->orderBy('nivel', 'asc')->get()->all();
        //dd($resp);
        return $resp;
    }

    /**
     * Obtiene todas las Cuentas de Materiales padre
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\CuentaMaterial
     */
    public function getBy($attribute, $operator, $value, $tipo)
    {
        return $this->model->where($attribute, $operator, $value)
                           ->where('tipo_material', $tipo)
                           ->orderBy('nivel', 'asc')->all();
    }
}