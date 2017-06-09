<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\Collection;
use Ghi\Domain\Core\Models\PolizaTipo;
use Ghi\Domain\Core\Contracts\PolizaTipoRepository;
use Mockery\Exception;

class EloquentPolizaTipoRepository implements PolizaTipoRepository
{

    private $model;

    private $movimiento;

    /**
     * EloquentPolizaTipoRepository constructor.
     * @param $model
     */
    public function __construct(
        PolizaTipo $model,
        EloquentMovimientoRepository $movimiento)
    {
        $this->model = $model;
        $this->movimiento = $movimiento;
    }


    /**
     * Obtiene todas las polizas tipo
     *
     * @return Collection|PolizaTipo
     */
    public function getAll()
    {
        return $this->model->all();
    }
    public function create($data){
        try {
            DB::connection('cadeco')->beginTransaction();

            $poliza_tipo = PolizaTipo::create([
                'id_transaccion_interfaz' => $data['id_transaccion_interfaz'],
                'registro' => auth()->user()->idusuario
            ]);

            foreach ($data['movimientos'] as $movimiento) {
                $this->movimiento->create($poliza_tipo->id, $movimiento);
            }
            DB::connection('cadeco')->commit();
            return true;
        }
        catch(\Exception $e){
            DB::connection('cadeco')->rollBack();
            return false;
        }
    }
}