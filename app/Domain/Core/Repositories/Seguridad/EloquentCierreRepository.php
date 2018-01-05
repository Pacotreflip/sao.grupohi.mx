<?php
namespace Ghi\Domain\Core\Repositories\Seguridad;

use Carbon\Carbon;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Ghi\Domain\Core\Contracts\Seguridad\CierreRepository;
use Ghi\Domain\Core\Models\Seguridad\Cierre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EloquentCierreRepository implements CierreRepository
{
    /**
     * @var Cierre
     */
    protected $model;

    public function __construct(Cierre $model)
    {
        $this->model = $model;
    }

    /**
     * Regresa todos los cierres
     * @return Collection | Cierre
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Regresa los Cierres Paginados de acuerdo a los parametros
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data)
    {
        $query = $this->model->with('userRegistro')->select('Configuracion.cierres.*')->orderBy('Configuracion.cierres.created_at', 'DESC');
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * Guarda un registro de Cierre
     * @param array $data
     * @throws \Exception
     * @return Cierre
     */
    public function create(array $data)
    {
        try {
            if($this->model->where('mes', '=', $data['mes'])->where('anio', '=', $data['anio'])->first()) {
                throw new HttpResponseException(new Response('Ya existe un cierre para el Periodo Seleccionado', 404));
            }

            DB::connection('seguridad')->beginTransaction();

            $cierre = $this->model->create($data);

            DB::connection('seguridad')->commit();
            return $cierre;
        } catch (\Exception $e) {
            DB::connection('seguridad')->rollback();
        }
    }

    /**
     * Regresa un registro específico de Cierre
     * @param $id
     * @return Cierre
     */
    public function find($id)
    {
        $cierre = $this->model->find($id);
        return $cierre;
    }

    /**
     * Abre un registro de cierre para poder registrar transacciones extemporaneas
     * @param array $data
     * @param $id
     * @return Cierre
     * @throws \Exception
     */
    public function open(array $data, $id)
    {
        try {
            $cierre = $this->model->find($id);

            if ($cierre->aperturas()->abiertas()->count()) {
                throw new HttpResponseException(new Response('El periodo de Cierre presenta ya una apertura activa', 404));
            }
            DB::connection('seguridad')->beginTransaction();

            $cierre->aperturas()->create($data);

            DB::connection('seguridad')->commit();

            return $cierre->with('aperturas')->first();
        } catch (\Exception $e) {
            DB::connection('seguridad')->rollback();
            throw $e;
        }
    }

    /**
     * Cierra un registro de cierre para poder registrar transacciones extemporaneas
     * @param $id
     * @return Cierre
     * @throws \Exception
     */
    public function close($id) {
        try {
            $cierre = $this->model->find($id);

            DB::connection('seguridad')->beginTransaction();

            $cierre->aperturas()->abiertas()->update([
                'fin_apertura' => Carbon::now()->toDateTimeString(),
                'estatus' => false
            ]);

            DB::connection('seguridad')->commit();

            return $cierre->with('aperturas')->first();

        } catch (\Exception $e) {
            DB::connection('seguridad')->rollback();
            throw $e;
        }
    }
}