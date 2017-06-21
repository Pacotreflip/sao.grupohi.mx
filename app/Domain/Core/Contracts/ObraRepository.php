<?php namespace Ghi\Domain\Core\Contracts;

interface ObraRepository
{
    /**
     * Busca y devuelve la obra por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\Obra
     * @throws \Exception
     */
    public function find($id);

    /**
     * Actualiza la información de la obra
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Obra
     * @throws \Exception
     */
    public function update(array $data, $id);
}