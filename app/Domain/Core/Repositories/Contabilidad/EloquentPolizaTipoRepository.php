<?php namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Carbon\Carbon;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaTipoRepository;
use Ghi\Domain\Core\Models\Contabilidad\MovimientoPoliza;
use Ghi\Domain\Core\Models\Contabilidad\PolizaTipo;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

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
        try {
            DB::connection('cadeco')->beginTransaction();

            $inicio_vigencia = Carbon::createFromFormat('Y-m-d H', $data['inicio_vigencia'] . ' 00');
            $fin_vigencia = Carbon::createFromFormat('Y-m-d H', $data['inicio_vigencia'] . ' 00')->subSecond();
            $fecha_minima = $this->model->fecha_minima($data['id_transaccion_interfaz']);

            if ($fecha_minima && $inicio_vigencia->lte($fecha_minima)) {
                throw new HttpResponseException(new Response('La fecha de Inicio de Vigencia debe ser mayor a ' . $fecha_minima->ToDateString() . ', ya que existe una plantilla que entrará en vigor en esa fecha', 400));
            }

            $ultima = $this->findBy('id_transaccion_interfaz', $data['id_transaccion_interfaz']);

            if ($ultima) {
                $ultima->update(['fin_vigencia' => $fin_vigencia]);
            }

            $poliza_tipo = $this->model->create([
                'id_transaccion_interfaz' => $data['id_transaccion_interfaz'],
                'registro' => auth()->user()->idusuario,
                'inicio_vigencia' => $inicio_vigencia
            ]);

            foreach ($data['movimientos'] as $movimiento) {
                $movimiento['id_poliza_tipo'] = $poliza_tipo->id;
                (new EloquentMovimientoRepository(new MovimientoPoliza()))->create($movimiento);
            }
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
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
    public function find($id, $with = null)
    {
        if ($with != null) {
            return $this->model->with($with)->find($id);
        }
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
        if ($with != null) {
            return $this->model->orderBy('id', 'DESC')->with($with)->where($attribute, '=', $value)->first();
        }
        return $this->model->orderBy('id', 'DESC')->where($attribute, '=', $value)->first();
    }

    public function delete($data, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            if (!$item = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la plantilla que se desea eliminar', 404));
            }
            array_push($data, ['cancelo' => auth()->user()->idusuario]);
            $item->update($data);

            foreach ($item->movimientos as $movimiento) {
                $movimiento->update($data);
                $movimiento->delete();
            }

            $item->destroy($id);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
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