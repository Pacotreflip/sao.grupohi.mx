<?php namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface PolizaRepository
{

    /**
     * Obtiene todas las polizas
     *
     * @return \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function all();

    /**
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function find($id);


    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     * @throws \Exception
     */
    public function update(array $data, $id);


    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations);

    /**
     * Paginador
     * @param $perPage
     * @return mixed
     */
    public function paginate($perPage);

    /**
     *  Contiene los parametros de búsqueda
     * @param array $where
     * @return mixed
     */
    public function where(array $where);

    /**
     * @param $array |$ids Poliza
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function findWhereIn($array);
    /**
     * Obtiene un scope sobre el modelo
     * @param string $scope
     * @return mixed
     */

    public function scope($scope);

}