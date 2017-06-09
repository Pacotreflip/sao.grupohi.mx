<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\TransaccionInterfazRepository;
use Ghi\Domain\Core\Models\TransaccionInterfaz;

class EloquentTransaccionInterfazRepository implements TransaccionInterfazRepository
{
    /**
     * Obtiene una Transaccion Interfaz por si ID
     *
     * @param $id
     * @return TransaccionInterfaz
     */
    public function getById($id)
    {
        return TransaccionInterfaz::find($id);
    }

    public function getAll() {
        return TransaccionInterfaz::all();
    }

    public function lists() {
        return TransaccionInterfaz::orderBy('descripcion', 'ASC')->lists('descripcion', 'id_transaccion_interfaz');
    }
}