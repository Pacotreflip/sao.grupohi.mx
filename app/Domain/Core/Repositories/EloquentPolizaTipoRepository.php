<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\Collection;
use Ghi\Domain\Core\Contracts\Model;
use Ghi\Domain\Core\Models\PolizaTipo;
use Ghi\Domain\Core\Contracts\PolizaTipoRepository;
use Illuminate\Support\Facades\DB;

class EloquentPolizaTipoRepository implements PolizaTipoRepository
{

    private $poliza_tipo;

    private $movimiento;

    /**
     * EloquentPolizaTipoRepository constructor.
     * @param PolizaTipo $poliza_tipo
     * @param EloquentMovimientoRepository $movimiento
     */
    public function __construct(
        PolizaTipo $poliza_tipo,
        EloquentMovimientoRepository $movimiento)
    {
        $this->poliza_tipo = $poliza_tipo;
        $this->movimiento = $movimiento;
    }


    /**
     * Obtiene todas las polizas tipo
     *
     * @return Collection|PolizaTipo
     */
    public function getAll()
    {
        return $this->poliza_tipo->all();
    }

    /**
     * Guarda un nuevo registro de Póliza Tipo con sus movimientos
     *
     * @param array $data
     * @return bool
     */
    public function create($data){
        try {
            DB::connection('cadeco')->beginTransaction();

            $poliza_tipo = PolizaTipo::create([
                'id_transaccion_interfaz' => $data['id_transaccion_interfaz'],
                'registro'                => auth()->user()->idusuario
            ]);

            foreach ($data['movimientos'] as $movimiento) {
                $movimiento['id_poliza_tipo'] = $poliza_tipo->id;
                $this->movimiento->create($movimiento);
            }
            DB::connection('cadeco')->commit();
            return $poliza_tipo;
        }
        catch(\Exception $e){
            DB::connection('cadeco')->rollBack();
            throw $e;
            return false;
        }
    }

    /**
     *  Busca y retona una Poliza Tipo por su ID
     * @param $id
     * @return Model
     */
    public function getById($id)
    {
        return PolizaTipo::find($id);
    }
}