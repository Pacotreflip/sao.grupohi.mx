<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 11/07/2017
 * Time: 05:26 PM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface NotificacionRepository
{
    /**
     * Obtiene todas las Notificaciones
     *
     * @return \Illuminate\Database\Eloquent\Collection|CuentaEmpresa
     */
    public function all();
    /**
     * @param $id
     */
    public function find($id);

    /**
     * Guarda una notificacion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Notificacion
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations);

    /**
     * Actualiza una notificacion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Notificacion
     * @throws \Exception
     */
    public function update(array $data, $id);

    /**
     * Obtiene un scope sobre el modelo
     * @param string $scope
     * @return mixed
     */

    public function scope($scope);

    /**
     * Las notificaciones que coincidan con la busqueda
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'));


}