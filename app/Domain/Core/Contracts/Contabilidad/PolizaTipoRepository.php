<?php namespace Ghi\Domain\Core\Contracts\Contabilidad;

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
     * @param $data
     * @param $id
     */
    public function delete($data, $id);

    /**
     * actualizar un registro de Plantilla de Tipo de Póliza
     * @param $data
     * @param $id
     */
    public function update($data, $id);
    /**
     * Crea relaciones eloquent
     * @param array|string $relations
     * @return mixed
     * @internal param array $array
     */
    public function with($relations);

    /**
     * Regresa registros de poliza tipo seleccionado
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data);
}