<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 05/07/2017
 * Time: 12:03 PM
 * User: EMARTINEZ
 * Date: 05/07/2017
 * Time: 01:50 PM
 */

namespace Ghi\Domain\Core\Contracts;


use Ghi\Domain\Core\Models\Material;

interface MaterialRepository
{
    /**
     * Obtiene todos los registros de Material
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Material
     * @param
     * @return Ghi\Domain\Core\Models\Material;
     */
    public function all();

    /**
     * Buscar materiales
     * @param $attribute
     * @param $operator
     * @param $value
     * @return \Illuminate\Database\Eloquent\Collection|Material
     */
    public function getBy($attribute, $operator, $value);

    /**
     * Obtiene un scope sobre el modelo
     * @param string $scope
     * @return mixed
     */
    public function scope($scope);

    /**
     * @param $value valor de busqueda de materiales de acuerdo a su tipo
     * @return mixed
     */
    public function findBy($value);

    /**
     * @param $value los datos de busqueda para un material padre y materiales hijos
     * @return mixed
     */
    public function find($tipo, $nivel);

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations);

    /**
     * Obtiene el nivel siguiente disponible de un tipo de material
     * @param $tipo
     * @return string
     */
    public function getNivelDisponible($tipo);

    /**
     * @param array $data
     * @return Material
     * @throws \Exception
     */
    public function create($data);

    /**
     * Actualiza el material seleccionado
     * @param $data
     * @param $id
     * @return \Ghi\Domain\Core\Models\Material
     */
    public function update($data, $id);

    /**
     * Elimina el material seleccionado
     * @param $data
     * @param $id
     * @return mixed
     */
    public function delete($data, $id);
}