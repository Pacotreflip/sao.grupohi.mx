<?php

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CambioInsumosRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoTarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\PartidasInsumosAgrupados;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Models\ControlPresupuesto\CambioInsumos;
use Ghi\Domain\Core\Models\Seguridad\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Config\Repository;
use Ghi\Domain\Core\Models\Obra;
use Ghi\Domain\Core\Models\User;
use Ghi\Domain\Core\Models\UsuarioCadeco;

class EloquentCambioInsumosRepository implements CambioInsumosRepository
{
    /**
     * @var CambioInsumos
     */
    private $model;
    /**
     * @var Repository
     */
    private $config;

    /**
     * EloquentSolicitudCambioRepository constructor.
     * @param CambioInsumos $model
     */
    public function __construct(CambioInsumos $model, Repository $config)
    {
        $this->model = $model;
        $this->config = $config;
    }

    /**
     * Obtiene todos los registros de CambioInsumos
     * @return CambioInsumos
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Regresa las Variaciones de Volúmen Paginadas
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $data)
    {
        $query = $this->model->with(['tipoOrden', 'userRegistro', 'estatus']);
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * Guarda un registro de CambioInsumos
     * @param array $data
     * @throws \Exception
     * @return CambioInsumos
     */
    public function create(array $data)
    {


        try {
            DB::connection('cadeco')->beginTransaction();

            $solicitud = $this->model->create($data);

            foreach ($data['agrupadas'] as $conceptoAgrupado) { /////////partidas agrupadas
                $partidaInsumo['id_solicitud_cambio'] = $solicitud->id;
                $partidaInsumo['id_concepto'] = $conceptoAgrupado;
                PartidasInsumosAgrupados::create($partidaInsumo);
            }

            foreach ($data['partidas'] as $partida) {

                $cantidad_presupuestada_concepto = $partida['cobrable']['cantidad_presupuestada'];

                ////////impacto materiales
                if (array_key_exists('insumos', $partida['conceptos']['MATERIALES'])) {
                    foreach ($partida['conceptos']['MATERIALES']['insumos'] as $material) {

                        if (isset($material['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $material['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $material['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }
                        $material['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $material['id_solicitud_cambio'] = $solicitud->id;
                        $material['precio_unitario_original'] = $material['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $material) ? $material['precio_unitario_nuevo'] = $material['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $material) ? $material['rendimiento_nuevo'] = $material['rendimiento_nuevo'] : '';
                        $material['rendimiento_original'] = $material['rendimiento_actual'];

                        //  dd($material['rendimiento_nuevo']);
                        if (array_key_exists('precio_unitario_nuevo', $material) || array_key_exists('rendimiento_nuevo', $material)) {
                            SolicitudCambioPartida::create($material);
                        }
                    }
                }
                ////////impacto Mano obra
                if (array_key_exists('insumos', $partida['conceptos']['MANOOBRA'])) {
                    foreach ($partida['conceptos']['MANOOBRA']['insumos'] as $mano) {
                        if (isset($mano['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $mano['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $mano['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }

                        $mano['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $mano['id_solicitud_cambio'] = $solicitud->id;
                        $mano['precio_unitario_original'] = $mano['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $mano) ? $mano['precio_unitario_nuevo'] = $mano['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $mano) ? $mano['rendimiento_nuevo'] = $mano['rendimiento_nuevo'] : '';
                        $mano['rendimiento_original'] = $mano['rendimiento_actual'];

                        if (array_key_exists('precio_unitario_nuevo', $mano) || array_key_exists('rendimiento_nuevo', $mano)) {
                            SolicitudCambioPartida::create($mano);
                        }
                    }
                }
                ////////impacto Herramienta y equipo
                if (array_key_exists('insumos', $partida['conceptos']['HERRAMIENTAYEQUIPO'])) {
                    foreach ($partida['conceptos']['HERRAMIENTAYEQUIPO']['insumos'] as $herramienta) {
                        if (isset($herramienta['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $herramienta['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $herramienta['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }
                        $herramienta['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $herramienta['id_solicitud_cambio'] = $solicitud->id;
                        $herramienta['precio_unitario_original'] = $herramienta['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $herramienta) ? $herramienta['precio_unitario_nuevo'] = $herramienta['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $herramienta) ? $herramienta['rendimiento_nuevo'] = $herramienta['rendimiento_nuevo'] : '';
                        $herramienta['rendimiento_original'] = $herramienta['rendimiento_actual'];

                        if (array_key_exists('precio_unitario_nuevo', $herramienta) || array_key_exists('rendimiento_nuevo', $herramienta)) {
                            SolicitudCambioPartida::create($herramienta);
                        }
                    }
                }

                ////////impacto Maquinaria

                if (array_key_exists('insumos', $partida['conceptos']['MAQUINARIA'])) {
                    foreach ($partida['conceptos']['MAQUINARIA']['insumos'] as $maquinaria) {
                        if (isset($maquinaria['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $maquinaria['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $maquinaria['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }
                        $maquinaria['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $maquinaria['id_solicitud_cambio'] = $solicitud->id;
                        $maquinaria['precio_unitario_original'] = $maquinaria['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $maquinaria) ? $maquinaria['precio_unitario_nuevo'] = $maquinaria['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $maquinaria) ? $maquinaria['rendimiento_nuevo'] = $maquinaria['rendimiento_nuevo'] : '';
                        $maquinaria['rendimiento_original'] = $maquinaria['rendimiento_actual'];

                        if (array_key_exists('precio_unitario_nuevo', $maquinaria) || array_key_exists('rendimiento_nuevo', $maquinaria)) {
                            SolicitudCambioPartida::create($maquinaria);
                        }


                    }
                }
            }

            //   dd($solicitud);
            $solicitud = $this->with('partidas')->find($solicitud->id);
            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch
        (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }


    }

    /**
     * Regresa un registro específico de CambioInsumos
     * @param $id
     * @return CambioInsumos
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function with($relations)
    {
        $this->model->with($relations);
        return $this;
    }

    /**
     * Autoriza una CambioInsumos
     * @param $id
     * @param array $data
     * @return CambioInsumos
     * @throws \Exception
     */
    public function autorizar($id, array $data)
    {

    }

    /**
     * Rechaza una CambioInsumos
     * @param array $data
     * @throws \Exception
     * @return CambioInsumos
     */
    public function rechazar(array $data)
    {

    }

    /**
     * Aplica una CambioInsumos a un Presupuesto
     * @param CambioInsumos $CambioInsumos
     * @param $id_base_presupuesto
     * @return void
     */
    public function aplicar(CambioInsumos $CambioInsumos, $id_base_presupuesto)
    {

    }

    public function enviarNotificacionRevasePresupuesto()
    {
        try {
            $basesDatos = Proyecto::get();

            foreach ($basesDatos as $bd) {
                $this->config->set('database.connections.cadeco.database', $bd->base_datos);
                $obras = Obra::all();


                foreach ($obras as $obra) {

                    $coordinadores_control_proyectos = collect(DB::connection('seguridad')
                        ->table('role_user')
                        ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                        ->leftJoin('proyectos', 'role_user.id_proyecto', '=', 'proyectos.id')
                        ->select('role_user.user_id')
                        ->where('role_user.id_obra', '=', $obra->id_obra)
                        ->where('proyectos.base_datos', '=', $bd->base_datos)
                        ->where('roles.name', '=', 'coordinador_control_proyectos')
                        ->get());

                    foreach ($coordinadores_control_proyectos as $coordinador_control_proyectos) {
                        $this->usuario = User::find($coordinador_control_proyectos->user_id);


                    }
                }
            }
        } catch (\Exception $e) {
            Log::info($e->getFile() . '  0' . $e->getLine());
            throw $e;
        }
    }
}