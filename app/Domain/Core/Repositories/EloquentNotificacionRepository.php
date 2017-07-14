<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 10/07/2017
 * Time: 07:00 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Ghi\Core\Models\BaseDatosCadeco;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\CuentaEmpresa;
use Ghi\Domain\Core\Contracts\NotificacionRepository;
use Ghi\Domain\Core\Models\Notificacion;
use Ghi\Domain\Core\Models\Obra;
use Ghi\Domain\Core\Models\User;
use Ghi\Domain\Core\Models\UsuarioCadeco;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Config\Repository;

class EloquentNotificacionRepository implements NotificacionRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Notificacion
     */
    private $model;

    /**
     * @var Repository
     */
    private $config;

    /**
     * @var PolizaRepository
     */
    private $poliza;

    /**
     * EloquentNotificacionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Notificacion $model
     */
    public function __construct(Notificacion $model, Repository $config, PolizaRepository $poliza)
    {
        $this->model = $model;
        $this->config = $config;
        $this->poliza = $poliza;
    }
    /**
     * Obtiene todas las Notificaciones
     *
     * @return \Illuminate\Database\Eloquent\Collection|CuentaEmpresa
     */
    public function all()
    {
        return $this->model->get();
    }
    /**
     * @param $id
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Guarda una notificacion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Notificacion
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $item = $this->model->create($data);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $item;
    }

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }


    /**
     * Actualiza una notificacion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Notificacion
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            $notificacion = $this->model->find($id);
            $notificacion->estatus = 0;
            $notificacion->update();
        } catch (\Exception $e) {
            throw $e;
        }
        return $notificacion;
    }

    /**
     * Obtiene un scope sobre el modelo
     * @param string $scope
     * @return mixed
     */

    public function scope($scope)
    {
        $this->model = $this->model->$scope();
        return $this;
    }
    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->model->paginate($perPage, $columns);
    }

    public function send() {

        $basesDatos = BaseDatosCadeco::where('activa', true)->orderBy('nombre')->get();

        foreach ($basesDatos as $bd) {
            $this->config->set('database.connections.cadeco.database', $bd->nombre);
            // hasta aqui toda va bien sin p2... creo


            // TODO: Obtener todos los usuarios con rol de contador dentro de la base

            /*foreach ($contadores as $contador) {
                $obras = Obra::all();
                foreach ($obras as $obra) {
                    if(//TODO: $contador tiene rol en $obra) {
                        $polizas = $this->poliza->scope('conErrores')->all();

                        $this->model->create([
                            'titulo' => 'Resumen de Errores',
                            'id_usuario' => $idUsuario,
                            'id_obra' => $obras->id_obra,
                        ]);
                    }
                }
            }*/


            DB::disconnect('cadeco');
        }

    }

    /**
     * Obtiene el usuario cadeco asociado al usuario de intranet
     *
     * @param $id_usuario
     * @return UsuarioCadeco
     * @internal param $idUsuario
     */
    public function getUsuarioCadeco($usuario)
    {
        return UsuarioCadeco::where('usuario', $usuario->usuario)->first();
    }

    /**
     * Obtiene las obras de un usuario cadeco
     *
     * @param UsuarioCadeco $usuarioCadeco
     * @return \Illuminate\Database\Eloquent\Collection|Obra
     */
    private function getObrasUsuario($usuarioCadeco)
    {
        if (! $usuarioCadeco) {
            return [];
        }

        if ($usuarioCadeco->tieneAccesoATodasLasObras()) {
            return Obra::orderBy('nombre')->get();
        }

        return $usuarioCadeco->obras()->orderBy('nombre')->get();
    }
}