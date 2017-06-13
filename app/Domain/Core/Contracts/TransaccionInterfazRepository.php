<?php namespace Ghi\Domain\Core\Contracts;

interface TransaccionInterfazRepository
{
    /**
     * Obtiene una Transacción Interfáz por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\TransaccionInterfaz
     */
    public function getById($id);

    /**
     * Obtiene todas las Transacciones Interfáz
     * @return \Illuminate\Database\Eloquent\Collection|TransaccionInterfaz
     */
    public function getAll();

    /**
     * Obtiene todas las Trasacciones Interfáz en forma de lista para combos
     * @return \Illuminate\Database\Eloquent\Collection|TransaccionInterfaz
     */
    public function lists();

    /**
     * Obtine las transacciones Interfaz q no estan asignadas en una plantilla
     * @return \Illuminate\Database\Eloquent\Collection|TransaccionInterfaz
     */
    public function getDisponibles();
}