<?php namespace Ghi\Domain\Core\Repositories;

use Carbon\Carbon;
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
    public function all()
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
        $poliza_tipo = null;

        try {
            DB::connection('cadeco')->beginTransaction();

            $inicio_vigencia = Carbon::createFromFormat('Y-m-d H', $data['inicio_vigencia']. ' 00');
            $fin_vigencia = Carbon::createFromFormat('Y-m-d H', $data['inicio_vigencia']. ' 00')->subSecond();

            $existe = $this->model->vigentes()->where('id_transaccion_interfaz', '=', $data['id_transaccion_interfaz'])->get();

            if (count($existe)) {
                foreach ($existe as $e) {
                    $e->fin_vigencia = $fin_vigencia;
                    $e->save();
                }
            }

            $poliza_tipo = $this->model->create([
                'id_transaccion_interfaz' => $data['id_transaccion_interfaz'],
                'registro'                => auth()->user()->idusuario,
                'inicio_vigencia'         => $inicio_vigencia
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
            return response()->json(['message' => $e->getMessage(), 'status_code' => $e->getCode()]);
        }
        return $poliza_tipo;
    }

    /**
     *  Obtiene Poliza Tipo por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Obtiene una Plantilla de Póliza que coincidan con la búsqueda
     * @param $attribute
     * @param $value
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     */
    public function findBy($attribute, $value, $with = null)
    {
        if($with != null) {
            return $this->model->with($with)->vigentes()->where($attribute, '=', $value)->first();

        }
        return $this->model->vigentes()->where($attribute, '=', $value)->first();
    }

    /**
     * Elimina un registro de Plantilla de Tipo de Póliza
     * @param $id
     * @return mixed
     */
    public function delete($data, $id) {
        try {
            DB::connection('cadeco')->beginTransaction();

            $item = $this->model->find($id);
            $item->update($data);

            $movimientos = (new EloquentMovimientoRepository(new MovimientoPoliza()))->getByPolizaTipoId($item->id);
            foreach ($movimientos as $movimiento) {
                $movimiento->update($data);
                $movimiento->delete();
            }

            $item->destroy($id);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $item;
    }

    /**
     * Actualiza una Plantilla con los parametros recibidos
     * @param $data
     * @param $id
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     */
    public function update($data, $id)
    {
        return $this->model->find($id)->update($data);
    }
}