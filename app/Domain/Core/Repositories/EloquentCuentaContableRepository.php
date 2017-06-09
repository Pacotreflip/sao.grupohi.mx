<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\CuentaContableRepository;
use Ghi\Domain\Core\Models\CuentaContable;

class EloquentCuentaContableRepository implements CuentaContableRepository
{

    public function lists() {
        $data = [];
        foreach (CuentaContable::all() as $item) {
            $data[$item->id_int_cuenta_contable] = (String) $item->tipoCuentaContable;
        }
        return collect($data);
    }

    public function getById($id)
    {
        return CuentaContable::find($id)->toArray();
    }
}