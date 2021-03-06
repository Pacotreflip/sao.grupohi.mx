<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 18/04/18
 * Time: 17:35
 */

namespace Ghi\Domain\Core\Repositories\Programacion;

use Ghi\Domain\Core\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Contracts\Procuracion\AsignacionesRepository;
use Ghi\Domain\Core\Models\Procuracion\Asignaciones;
use Illuminate\Support\Facades\Log;

class EloquentAsignacionesRepository implements AsignacionesRepository
{
    /**
     * @var Asignaciones
     */
    private $model;

    /**
     * EloquentAsignacionesRepository constructor.
     * @param Asignaciones $model
     */
    public function __construct(Asignaciones $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Procuracion\Asignaciones
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Guartdar un nuevo registro
     * @param array $data
     * @return TraspasoCuentas
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            /*
             * Prueba
             */
            $user = User::find($data['id_usuario_asignado']);
            $record = $user->transaccionesAsignadas()->attach($data['id_transaccion'], [
                'id_usuario_asigna' => auth()->user()->idusuario,
                'numero_folio' => Asignaciones::getFolio()
            ]);

            //$record = $this->model->create($data);
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $record;
    }

    /**
     * @param array $relations
     * @return $this|mixed
     */
    public function with(array $relations) {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param array $where
     * @return $this|mixed
     */
    public function where(array $where) {
        $this->model = $this->model->where($where);
        return $this;
    }
    /**
     * Aplica un SoftDelete a la asignacion seleccionada
     * @param $id Identificador del registro de asinacion se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $item = $this->model->where('id', '=', $id)->first();

            if (!$item) {
                throw new \Exception('no se esta el registro');
            }
            $item->id_usuario_deleted = auth()->user()->idusuario;
            $item->update();
            $item->delete($id);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $id;
    }

    /**
     * Regresa las Asignaciones Paginados de acuerdo a los parametros
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data)
    {
        $query = $this->model
            ->select('Procuracion.asignaciones.numero_folio as asignaciones_numero_folio', 'Procuracion.asignaciones.*')
            ->join(DB::raw('dbo.transacciones as transacciones'), 'Procuracion.asignaciones.id_transaccion', '=', 'transacciones.id_transaccion')
            ->join(DB::raw('dbo.[TipoTran] as tipo_transaccion'), 'transacciones.tipo_transaccion', '=', 'tipo_transaccion.Tipo_Transaccion')
        ;
        $query->where(function ($query) use ($data) {
            $query->where('tipo_transaccion.tipo_transaccion', '=', '17')->where('tipo_transaccion.Opciones', '=', '1')
            ;
            $query->orwhere('tipo_transaccion.tipo_transaccion', '=', '49')->where('tipo_transaccion.Opciones', '=', '1026')
            ;
        });
        if (!empty($data['columns']['4']['search']['value'])) {
            $query->where(function ($query) use ($data) {
                $query->where('id_usuario_asignado', '=', $data['columns']['4']['search']['value']);
            });
        }
        if(!empty($data['columns']['1']['search']['value'])) {
            $query->where(function ($query) use ($data) {
                $query->where('tipo_transaccion.Descripcion',  'like', '%' .  $data['columns']['1']['search']['value']. '%');
            });
        }
        if (!empty($data['columns']['2']['search']['value'])) {
            $query->where(function ($query) use ($data) {
                $query->where('transacciones.numero_folio', 'like', '%' . $data['columns']['2']['search']['value'] . '%');
            });
        }
        foreach ($data['order'] as $order) {
            $column = ($data['columns'][$order['column']]['data'] == 'asignaciones_numero_folio') ? 'Procuracion.asignaciones.numero_folio' : $data['columns'][$order['column']]['data'];
            $query->orderBy($column, $order['dir']);
        }
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * @param array $data
     * @return array|mixed
     */
    public function exists(array $data)
    {
        $where = [
            ['id_transaccion', '=', $data['id_transaccion']],
            ['id_usuario_asignado', '=', $data['id_usuario_asignado']]
        ];
        $whereAsignacion = $this->model->with(['usuario_asigna','usuario_asignado','transaccion.tipotran','transaccion'])->where($where)->first();

        return $whereAsignacion;
    }

    /**
     * @return $this|mixed
     */
    public function refresh()
    {
        self::__construct(new Asignaciones);
        return $this;
    }
}