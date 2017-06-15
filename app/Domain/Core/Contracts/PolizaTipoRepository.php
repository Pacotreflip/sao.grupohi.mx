<?php namespace Ghi\Domain\Core\Contracts;

interface PolizaTipoRepository
{
    /**
     * Obtiene todas las polizas tipo
     *
     * @return \Illuminate\Database\Eloquent\Collection|PolizaTipo
     */
    public function all();

    /**
     * Guarda un nuevo registro de Póliza Tipo con sus movimientos
     *
     * @param  $data
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     */
    public function create($data);

    /**
     *  Obtiene Poliza Tipo por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     */
    public function find($id, $with = null);

    /**
     * Obtiene una Plantilla de Póliza que coincidan con la búsqueda
     * @param $attribute
     * @param $value
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     */
    public function findBy($attribute, $value, $with = null);

    /**
     * Elimina un registro de Plantilla de Tipo de Póliza
     * @param $id
     * @return mixed
     */
    public function delete($data, $id);

    /**
     * Verifica si una fecha dada comple con la condición de creación de Plantilla
     * @param $fecha
     * @param $id
     * @return string $fecha
     */
    public function check_fecha($fecha, $id);
}