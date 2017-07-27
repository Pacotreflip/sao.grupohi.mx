<?php namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface PolizaMovimientoRepository
{
    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|PolizaMovimiento
     */
    public function find($id);


    /**
     * Obtiene todos los movimientos
     *
     * @return \Illuminate\Database\Eloquent\Collection|PolizaMovimiento
     */
    public function all();

    /**
     *  Contiene los parametros de búsqueda
     * @param array $where
     * @return mixed
     */
    public function where(array $where);

    /**
     * @param array $data
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|PolizaMovimiento
     * @throws \Exception
     */
    public function update(array $data, $id);

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations);

    public function scope($scope);
}