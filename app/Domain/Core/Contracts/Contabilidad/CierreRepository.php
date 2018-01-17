<?php
namespace Ghi\Domain\Core\Contracts\Contabilidad;

use Ghi\Domain\Core\Models\Contabilidad\Cierre;
use Illuminate\Database\Eloquent\Collection;

interface CierreRepository
{
    /**
     * Regresa todos los cierres
     * @return Collection | Cierre
     */
    public function all();

    /**
     * Regresa los Cierres Paginados de acuerdo a los parametros
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data);

    /**
     * Guarda un registro de Cierre
     * @param array $data
     * @throws \Exception
     * @return Cierre
     */
    public function create(array $data);

    /**
     * Regresa un registro específico de Cierre
     * @param $id
     * @return Cierre
     */
    public function find($id);

    /**
     * Abre un registro de cierre para poder registrar transacciones extemporaneas
     * @param array $data
     * @param $id
     * @return Cierre
     * @throws \Exception
     */
    public function open(array $data, $id);

    /**
     * Cierra un registro de cierre para poder registrar transacciones extemporaneas
     * @param $id
     * @return Cierre
     * @throws \Exception
     */
    public function close($id);
}
