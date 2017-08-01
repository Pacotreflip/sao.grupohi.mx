<?php

namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface RevaluacionRepository
{
    /**
     * Obtiene todas las revaluacion
     * @return \Illuminate\Database\Eloquent\Collection | \Ghi\Domain\Core\Models\Contabilidad\Revaluacion;

     */
    public function all();

    /**
     * Guarda un registro de Revaluacion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\Revaluacion
     * @throws \Exception
     */
    public function create(array $data);


    /**
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\Revaluacion
     */
    public function find($id);

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations);

    /**
     * Obtiene el tipo de cambio del ultimo dia habil del mes en curso
     * @return float
     */
    public function getTipoCambio();


}