<?php namespace Ghi\Domain\Core\Contracts;

interface PolizaTipoRepository
{
    /**
     * Obtiene todas las polizas tipo
     *
     * @return \Illuminate\Database\Eloquent\Collection|PolizaTipo
     */
    public function getAll();

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
    public function getById($id);

    /**
     * Elimina un registro de Plantilla de Tipo de Póliza
     * @param $id
     * @return mixed
     */
    public function delete($id);
}