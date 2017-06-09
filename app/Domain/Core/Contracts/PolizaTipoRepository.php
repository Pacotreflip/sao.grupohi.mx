<?php namespace Ghi\Domain\Core\Contracts;

interface PolizaTipoRepository
{
    /**
     * Obtiene todas las polizas tipo
     *
     * @return Collection|PolizaTipo
     */
    public function getAll();

    /**
     * Guarda un nuevo registro de Póliza Tipo con sus movimientos
     *
     * @param array $data
     * @return bool
     */
    public function create($data);

    /**
     *  Busca y retona una Poliza Tipo por su ID
     * @param $id
     * @return Model
     */
    public function getById($id);
}