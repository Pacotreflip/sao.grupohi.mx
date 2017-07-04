<?php
namespace Ghi\Domain\Core\Contracts\Contabilidad;



interface DatosContablesRepository
{
    /**
     * Obtiene los datos contables de una obra que coincidan con los atributos de búsqueda
     * @param string $attribute
     * @param mixed $value
     * @return \Ghi\Domain\Core\Models\Contabilidad\DatosContables
     */
    public function findBy($attribute, $value);

    /**
     * @param array $data
     * @param $id
     * @return DatosContables
     * @throws \Exception
     */
    public function update(array $data, $id);

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     * @internal param array $array
     */
    public function with($relations);

    /**
     * Buscar datos contables por su id
     * @param $id
     * @return mixed
     */
    public function find($id);
}