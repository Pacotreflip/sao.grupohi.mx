<?php namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface PolizaTipoSAORepository
{
    /**
     * Obtiene un elemento por id
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\PolizaTipoSAO
     */
    public function find($id);

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|PolizaTipoSAO
     */
    public function all();

    /**
     * Obtiene todas las elementos en forma de lista
     * @return \Illuminate\Database\Eloquent\Collection|PolizaTipoSAO
     */
    public function lists();

    /**
     * Crea relaciones eloquent
     * @param array|string $relations
     * @return mixed
     * @internal param array $array
     */
    public function with($relations);
}