<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\PolizaTipoRepository;
use Ghi\Domain\Core\Models\MovimientoPoliza;
use Ghi\Domain\Core\Models\PolizaTipo;
use Illuminate\Support\Facades\DB;

class EloquentPolizaTipoRepository implements PolizaTipoRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\PolizaTipo
     */
    private $model;

    /**
     * EloquentPolizaTipoRepository constructor.
     * @param \Ghi\Domain\Core\Models\PolizaTipo $model
     */
    public function __construct(PolizaTipo $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las polizas tipo
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\PolizaTipo
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Guarda un nuevo registro de Póliza Tipo con sus movimientos
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $poliza_tipo = $this->model->create([
                'id_transaccion_interfaz' => $data['id_transaccion_interfaz'],
                'registro'                => auth()->user()->idusuario
            ]);

            foreach ($data['movimientos'] as $movimiento) {
                $movimiento['id_poliza_tipo'] = $poliza_tipo->id;
                (new EloquentMovimientoRepository(new MovimientoPoliza()))->create($movimiento);
            }
            DB::connection('cadeco')->commit();
        }
        catch(\Exception $e){
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $poliza_tipo;
    }

    /**
     *  Obtiene Poliza Tipo por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Elimina un registro de Plantilla de Tipo de Póliza
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        $this->model->destroy($id);
    }
}