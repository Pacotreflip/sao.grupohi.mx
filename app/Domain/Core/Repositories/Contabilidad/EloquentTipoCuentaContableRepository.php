<?php namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\Identificador;
use Ghi\Domain\Core\Contracts\Motivo;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaContableRepository;
use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaContable;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EloquentTipoCuentaContableRepository implements TipoCuentaContableRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Contabilidad\TipoCuentaContable
     */
    protected $model;

    /**
     * EloquentTipoCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\TipoCuentaContable $model
     */
    public function __construct(TipoCuentaContable $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los Tipos de Cuentas Contables
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\TipoCuentaContable
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     *  Obtiene Tipo de Cuenta Contable por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\TipoCuentaContable
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Guarda un nuevo registro de Tipo de Cuenta Contable
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\TipoCuentaContable
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $tipo_cuenta_contable = $this->model->create([
                'descripcion' => $data['descripcion'],
                'registro' => auth()->user()->idusuario,
                'id_obra' => Context::getId(),
                'id_naturaleza_poliza'=> $data['id_naturaleza_poliza']
            ]);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $tipo_cuenta_contable;
    }

    /**
     * Aplica un SoftDelete al Tipo de Cuenta Contable seleccionado
     * @param $data Motivo por el cual se elimina el registro
     * @param $id Identificador del registro de Tipo de Cuenta Contable que se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($data, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            if (!$item = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la plantilla que se desea eliminar', 404));
            }

            if ($item->cuentaContable) {
                throw new HttpResponseException(new Response('No se puede eliminar el Tipo de Cuenta ya que se encuentra configurada con una cuenta contable', 400));
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
     * Obtienes los tipos de cuentas contables en lista para combo
     * @return array
     */
    public function lists()
    {
        return $this->model->orderBy('descripcion', 'ASC')->lists('descripcion', 'id_tipo_cuenta_contable');
    }

    /**Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     * @internal param array $array
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Obtiene un scope sobre el modelo
     * @param string $scope
     * @return mixed
     */
    public function scope($scope)
    {
        $this->model = $this->model->$scope();
        return $this;
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|TipoCuentaContable
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            $cuenta = $this->model->find($id);
            $cuenta->registro = auth()->user()->idusuario;
            $cuenta->update($data);
        } catch (\Exception $e) {
            throw $e;
        }

        return $cuenta;
    }
}
