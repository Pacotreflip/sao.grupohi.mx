<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 31/07/2017
 * Time: 04:34 PM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;


use Ghi\Domain\Core\Models\Contabilidad\Factura;

interface FacturaRepository
{
    /**
     * Obtiene todas las facturas
     *
     * @return \Illuminate\Database\Eloquent\Collection|Factura
     */
    public function all();

    /**
     *  Obtiene Factura por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\Factura
     */
    public function find($id);

    /**
     * Guarda un nuevo registro de factura
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\Factura
     * @throws \Exception
     */
    public function create($data);

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Factura
     * @throws \Exception
     */
    public function delete(array $data, $id);

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Factura
     * @throws \Exception
     */
    public function update(array $data, $id);

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations);

    /**
     *  Contiene los parametros de búsqueda
     * @param array $where
     * @return mixed
     */
    public function where(array $where);

    /**
     * Obtiene un scope sobre el modelo
     * @param string $scope
     * @return mixed
     */

    public function scope($scope);
}