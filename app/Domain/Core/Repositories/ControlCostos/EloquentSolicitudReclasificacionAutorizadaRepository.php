<?php

namespace Ghi\Domain\Core\Repositories\ControlCostos;

use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionAutorizadaRepository;
use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionRepository;
use Ghi\Domain\Core\Contracts\ItemRepository;
use Ghi\Domain\Core\Contracts\MovimientosRepository;
use Ghi\Domain\Core\Models\ControlCostos\SolicitudReclasificacion;
use Ghi\Domain\Core\Models\ControlCostos\SolicitudReclasificacionAutorizada;
use Ghi\Domain\Core\Models\Items;
use Ghi\Domain\Core\Models\Movimientos;

use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;

class EloquentSolicitudReclasificacionAutorizadaRepository implements SolicitudReclasificacionAutorizadaRepository
{
    /**
     * @var SolicitudReclasificacionAutorizada
     */
    private $model;
    /**
     * @var Items
     */
    private $items;
    /**
     * @var Movimientos
     */
    private $movimientos;

    /**
     * EloquentSolicitudReclasificacionAutorizadaRepository constructor.
     * @param SolicitudReclasificacionAutorizada $model
     * @param Items $items
     * @param Movimientos $movimientos
     * @param SolicitudReclasificacion $solicitud
     */
    public function __construct(SolicitudReclasificacionAutorizada $model, Items $items, Movimientos $movimientos, SolicitudReclasificacion $solicitud)
    {
        $this->model = $model;
        $this->items = $items;
        $this->movimientos = $movimientos;
        $this->solicitud = $solicitud;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function create($data)
    {
        $error = 'No se encontró el item que se desea actualizar';
        $item_done = false;
        $mov_done = false;

            // Una transacción para cada partida
            foreach ($data['partidas'] as $partida)
            {
                try {
                    $item = Items::where('id_item', '=', $partida['item']['id_item'])
                        ->where('id_concepto', '=', $partida['concepto_original']['id_concepto']);

                    if (!$item)
                        throw new HttpResponseException(new Response($error, 404));

                    DB::connection('cadeco')->beginTransaction();
                    $item->update([
                        'id_concepto' => $partida['concepto_nuevo']['id_concepto'],
                    ]);
                    $item_done = true;

                    $movimiento = Movimientos::where('id_item', '=', $partida['item']['id_item'])
                        ->where('id_concepto', '=', $partida['concepto_original']['id_concepto']);

                    if (!$movimiento)
                        throw new HttpResponseException(new Response($error, 404));

                    $movimiento->update([
                        'id_concepto' => $partida['concepto_nuevo']['id_concepto'],
                    ]);
                    $mov_done = true;

                    // Cambia el estado a la solicitud
                    $solicitud = SolicitudReclasificacion::where('id', '=', $data['id']);

                    // Estatus 2 Autorizada
                    $solicitud->update([
                        'estatus' => 2,
                    ]);

                    DB::connection('cadeco')->commit();

                } catch (\Exception $e) {
                    DB::connection('cadeco')->rollBack();
                    throw $e;
                }
            }

            if ($item_done && $mov_done)
                try {
                    DB::connection('cadeco')->beginTransaction();
                    $record = SolicitudReclasificacionAutorizada::create([
                        'id_solicitud_reclasificacion' => $data['id'],
                        'motivo' => $data['motivo'],
                    ]);
                    DB::connection('cadeco')->commit();

                } catch (\Exception $e) {
                    DB::connection('cadeco')->rollBack();
                    throw $e;
                }

        return $this->model->where('id_solicitud_reclasificacion', '=', $data['id'])->first();
    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations) {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data)
    {
        $query = $this->model->with(['usuario', 'estatus', 'partidas.item.material', 'partidas.item.transaccion.tipoTransaccion', 'partidas.conceptoNuevo', 'partidas.conceptoOriginal'])->select('ControlCostos.solicitud_reclasificacion.*')->orderBy('ControlCostos.solicitud_reclasificacion.created_at', 'DESC');
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $data
     * @param $id
     */
    public function update($data, $id)
    {
        // TODO: Implement update() method.
    }
}
