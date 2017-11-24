<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 07/11/2017
 * Time: 10:56
 */

namespace Ghi\Domain\Core\Repositories;

use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Ghi\Domain\Core\Contracts\ContratoRepository;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class EloquentContratoRepository implements ContratoRepository
{

    /**
     * @var Contrato
     */
    private $model;

    /**
     * EloquentContratoRepository constructor.
     * @param Contrato $model
     */
    public function __construct(Contrato $model)
    {
        $this->model = $model;
    }

    /**
     * Actualiza un registro de Contrato
     * @return Contrato
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        $contrato = $this->model->find($id);
        $contrato->fillable([
            'cantidad_presupuestada',
            'cantidad_original'
        ]);

        $contrato->update($data);

        return $contrato;
    }

    /**
     * Busca un Contrato por su ID
     * @param $id
     * @return Contrato
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
}