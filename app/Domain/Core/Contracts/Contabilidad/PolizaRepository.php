<?php namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface PolizaRepository
{

    /**
     * Obtiene todas las polizas
     *
     * @return \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function all();

    /**
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function find($id);


    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     * @throws \Exception
     */
    public function update(array $data, $id);


    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations);

    /**
     * @param $array |$ids Poliza
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function findWhereIn($array);

}