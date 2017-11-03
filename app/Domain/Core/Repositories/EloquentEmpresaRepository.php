<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 06:39 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Couchbase\Exception;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response;
use Ghi\Domain\Core\Contracts\EmpresaRepository;
use Ghi\Domain\Core\Contracts\Ghi;
use Ghi\Domain\Core\Models\Contabilidad\CuentaEmpresa;
use Ghi\Domain\Core\Models\Empresa;
use Illuminate\Support\Facades\DB;


class EloquentEmpresaRepository implements EmpresaRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Empresa
     */
    private $model;

    /**
     * EloquentObraRepository constructor.
     * @param \Ghi\Domain\Core\Models\Empresa $model
     */
    public function __construct(Empresa $model)
    {
        $this->model = $model;
    }

    /**
     * @return Empresa
     * @internal param $with
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id
     * @return CuentaEmpresa
     */
    public function find($id)
    {
        return $this->model->find($id);
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
     * Aplica un scope a la consulta de Empresas
     */
    public function scope($scope)
    {
        $this->model = $this->model->$scope();
        return $this;
    }

    /**
     * Crea una nueva Empresa
     */
    public function create(array $data) {
        DB::connection('cadeco')->beginTransaction();

        try {
            //Reglas de validación para crear una empresa
            $rules = [
                'rfc' => ['required', 'unique:cadeco.empresas'],
                'tipo_empresa' => ['required'],
                'razon_social' => ['required', 'unique:cadeco.empresas']
            ];

            //Mensajes de error personalizados para cada regla de validación
            $messages = [
                'rfc.unique' => 'Ya existe una Empresa con el RFC proporcionado',
                'razon_social.unique' => 'Ya existe una Empresa con la Razón Social proporcionada'
            ];

            //Validar los datos recibidos con las reglas de validación
            $validator = app('validator')->make($data, $rules, $messages);

            if(count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al crear la empresa', $validator->errors());
            } else {
                //Crear empresa nueva si la validación no arroja ningún error
                $empresa = $this->model->create($data);
                DB::connection('cadeco')->commit();
                return $empresa;
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}