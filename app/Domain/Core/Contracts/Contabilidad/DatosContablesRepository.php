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
}