<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 27/06/2017
 * Time: 02:27 PM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface ConceptoRepository
{
    /**
     * Buscar conceptos
     * @param $attribute
     * @param $operator
     * @param $value
     * @return \Illuminate\Database\Eloquent\Collection|Concepto
     */
    public function getBy($attribute, $operator, $value, $with = null);

    /**
     * Obtiene un Concepto que coincida con los parametros de búsqueda
     * @param $attribute
     * @param $value
     * @return \Illuminate\Database\Eloquent\Model|Concepto
     */
    public function findBy($attribute, $value, $with = null);

    /**
     * Obtiene los conceptos raiz del presupuesto de obra
     *
     * @return Collection|Concepto
     */
    public function getRootLevels();

    /**
     * Obtiene los descendientes de un concepto
     *
     * @param $id
     * @return Collection|Concepto
     */
    public function getDescendantsOf($id);

    /**
     * {@inheritdoc}
     */
    public function getById($id);

    public function paths(array $data,$baseDatos=null);
    public function pathsConceptos(array $data);

    /**
     * Obtiene los insumos de un concepto medible
     * @param $id
     * @return mixed
     */
    public function getInsumos($id);
    /**
     * Obtiene los precios disponibles en conceptos por material
     * @param $id
     * @return mixed
     */
    public function getPreciosConceptos($id);

    /**
     * Obtiene los insumos desdeuna tarjeta para extraordinario
     * @param $id_tarjeta
     * @return mixed
     */
    public function getInsumosPorTarjeta($id_tarjeta);
}