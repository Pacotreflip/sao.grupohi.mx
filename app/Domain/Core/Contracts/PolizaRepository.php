<?php namespace Ghi\Domain\Core\Contracts;


interface PolizaRepository
{

    /**
     * Obtiene todas las polizas
     *
     * @return \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function all($with = null);

    /**
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function find($id, $with = null);


    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     * @throws \Exception
     */
    public function update(array $data, $id);
}