<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/06/2018
 * Time: 01:48 PM
 */

namespace Ghi\Domain\Core\Repositories\Finanzas;


use Ghi\Domain\Core\Contracts\Finanzas\SolicitudRecursosRepository;
use Ghi\Domain\Core\Models\Finanzas\SolicitudRecursos;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentSolicitudRecursosRepository
 * @package Ghi\Domain\Core\Repositories\Finanzas
 */
class EloquentSolicitudRecursosRepository implements SolicitudRecursosRepository
{

    /**
     * @var SolicitudRecursos
     */
    protected $model;

    /**
     * EloquentSolicitudRecursosRepository constructor.
     * @param SolicitudRecursos $solicitudRecursos
     */
    public function __construct(SolicitudRecursos $solicitudRecursos)
    {
        $this->model = $solicitudRecursos;
    }

    /**
     * Crea un registro de Solicitud de Recursos con sus Partidas
     *
     * @param array $data
     * @return SolicitudRecursos|mixed
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $record = $this->model->create($data);

            foreach ($data['partidas'] as $partida) {
                $record->partidas()->create($partida);
            }

            DB::connection('cadeco')->commit();
            return $record;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}