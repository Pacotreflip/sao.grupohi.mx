<?php
namespace Ghi\Domain\Core\Contracts\Seguridad;

use Ghi\Domain\Core\Models\Seguridad\Cierre;
use Illuminate\Database\Eloquent\Collection;

interface CierreRepository
{
    /**
     * Obtiene todos los registros de dias Cierre
     *
     * @return Collection | Cierre
     */
    public function all();
    public function paginate(array $data);
}
