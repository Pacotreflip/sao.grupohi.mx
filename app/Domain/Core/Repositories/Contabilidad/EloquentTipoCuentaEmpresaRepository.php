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
use Illuminate\Support\Facades\DB;

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
        return $this->model->get();
    }

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     *  Contiene los parametros de búsqueda
     * @param array $where
     * @return mixed
     */
    public function where(array $where)
    {
        $this->model = $this->model->where($where);
        return $this;
    }

    /**
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|TipoCuentaEmpresa
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Guarda un nuevo registro de TipoCuentaEmpresa
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\TipoCuentaEmpresa
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $modelo = $this->model;
            $modelo->descripcion = $data['descripcion'];
            $modelo->id_tipo_cuenta_contable = $data['id_tipo_cuenta_contable'];
            $modelo->save();

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $this->find($modelo->id);
    }
}