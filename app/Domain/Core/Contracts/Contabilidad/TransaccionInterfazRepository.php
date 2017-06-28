<?php namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface TransaccionInterfazRepository
{
    /**
     * Obtiene una Transacción Interfáz por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\TransaccionInterfaz
     */
    public function find($id);

    /**
     * Obtiene todas las Transacciones Interfáz
     * @return \Illuminate\Database\Eloquent\Collection|TransaccionInterfaz
     */
    public function all();

    /**
     * Obtiene todas las Trasacciones Interfáz en forma de lista para combos
     * @return \Illuminate\Database\Eloquent\Collection|TransaccionInterfaz
     */
    public function lists();
}