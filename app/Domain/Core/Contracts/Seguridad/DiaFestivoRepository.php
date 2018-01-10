<?php
namespace Ghi\Domain\Core\Contracts\Seguridad;

interface DiaFestivoRepository
{
    /**
     * Obtiene todos los registros de dias festivos
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Seguridad\DiaFestivoRepository
     */
    public function all();

    /**
     * @param $id Identificador del dia festivo
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Seguridad\DiaFestivoRepository
     */
    public function find($id);

    /**Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations);
}