<?php

namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface CostoRepository
{
    /**
     * Buscar Costos
     * @param $attribute
     * @param $operator
     * @param $value
     * @return \Illuminate\Database\Eloquent\Collection|Costo
    */
    public function getBy($attribute, $operator, $value, $with = null);

    /**
     * Obtiene un Costo que coincida con los parametros de búsqueda
     * @param $attribute
     * @param $value
     * @return \Illuminate\Database\Eloquent\Model|Costo
     */
    public function findBy($attribute, $value, $with = null);

    /**
     * Obtiene los Costos raiz del presupuesto de obra
     *
     * @return Collection|Costo
     */
    public function getRootLevels();

    /**
     * Obtiene los descendientes de un Costo
     *
     * @param $id
     * @return Collection|Costo
     */
    public function getDescendantsOf($id);

    /**
     * {@inheritdoc}
     */
    public function getById($id);
}