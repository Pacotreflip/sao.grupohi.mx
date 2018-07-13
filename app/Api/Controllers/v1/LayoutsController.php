<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/04/2018
 * Time: 01:00 PM
 */

namespace Ghi\Api\Controllers\v1;


use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Contracts\ContratoProyectadoRepository;
use Ghi\Domain\Core\Layouts\Compras\AsignacionCargaProveedoresLayout;
use Ghi\Domain\Core\Layouts\Compras\AsignacionProveedoresLayout;
use Ghi\Domain\Core\Layouts\Contratos\AsignacionSubcontratistasLayout;
use Ghi\Domain\Core\Layouts\Presupuestos\AsignacionCargaPreciosLayout;
use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Ghi\Http\Controllers\Controller as BaseController;

/**
 * Class LayoutsController
 * @package Ghi\Api\Controllers\v1
 */
class LayoutsController extends BaseController
{
    use Helpers;

    /**
     * @var RequisicionRepository
     */
    protected $requisicionRepository;

    /**
     * @var ContratoProyectadoRepository
     */
    protected $contratoProyectadoRepository;

    /**
     * LayoutsController constructor.
     * @param RequisicionRepository $requisicionRepository
     */
    public function __construct(RequisicionRepository $requisicionRepository, ContratoProyectadoRepository $contratoProyectadoRepository)
    {
        $this->requisicionRepository = $requisicionRepository;
        $this->contratoProyectadoRepository = $contratoProyectadoRepository;
    }

    /**
     * @param Request $request
     * @param $id_requisicion
     * @return mixed
     */
    public function compras_asignacion(Request $request, $id_requisicion)
    {
        $requisicion = $this->requisicionRepository->find($id_requisicion);
        $layout = (new AsignacionProveedoresLayout($requisicion))->getFile();

        try {
            return $this->response->array([
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($layout->string()),
                'name' => '# ' . str_pad($requisicion->numero_folio, 5, '0', STR_PAD_LEFT) . '-AsignacionProveedores'
            ]);
        } catch (\ErrorException $e) {
        }
    }

    /**
     * @param Request $request
     * @param $id_requisicion
     * @return mixed
     */
    public function compras_asignacion_store(Request $request, $id_requisicion)
    {
        $rules = array(
            'file' => 'required|mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-office',
        );

        $validator = app('validator')->make($request->all(), $rules);
        if (count($validator->errors()->all())) {
            throw new StoreResourceFailedException('No es posible cargar el Layout', $validator->errors());
        }
        $requisicion = $this->requisicionRepository->find($id_requisicion);
        $layout = (new AsignacionProveedoresLayout($requisicion))->qetDataFile($request);

        return $this->response->array($layout);
    }

    /**
     * @param Request $request
     * @param $id_contrato_proyectado
     * @return mixed
     */
    public function contratos_asignacion(Request $request, $id_contrato_proyectado)
    {
        $contrato_proyectado = $this->contratoProyectadoRepository->find($id_contrato_proyectado);
        $layout = (new AsignacionSubcontratistasLayout($contrato_proyectado))->getFile();

        try {
            return $this->response->array([
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($layout->string()),
                'name' => '# ' . str_pad($contrato_proyectado->numero_folio, 5, '0', STR_PAD_LEFT) . '-AsignacionContratistas'
            ]);
        } catch (\ErrorException $e) {
        }
    }

    /**
     * @param Request $request
     * @param $id_contrato_proyectado
     * @return mixed
     */
    public function contratos_asignacion_store(Request $request, $id_contrato_proyectado)
    {
        $rules = array(
            'file' => 'required|mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-office',
        );

        $validator = app('validator')->make($request->all(), $rules);
        if (count($validator->errors()->all())) {
            throw new StoreResourceFailedException('No es posible cargar el Layout', $validator->errors());
        }

        $contrato_proyectado = $this->contratoProyectadoRepository->find($id_contrato_proyectado);
        $layout = (new AsignacionSubcontratistasLayout($contrato_proyectado))->qetDataFile($request);

        return $this->response->array($layout);
    }

    /**
     * @param Request $request
     * @param $id_contrato_proyectado
     * @return mixed
     */
    public function carga_precios_asignacion(Request $request, $id_contrato_proyectado)
    {
        // Obten la información de los filtros y agrupaciones
        $info = [
            'id_contrato_proyectado' => $id_contrato_proyectado,
            'presupuesto_ids' => (is_string($request->ids) ? json_decode($request->ids, true) : $request->ids),
            'agrupadores' => !empty($request->agrupadores) ? explode(',', $request->agrupadores) : '',
            'solo_pendientes' => $request->solo_pendientes
        ];

        $layout = (new AsignacionCargaPreciosLayout($this->contratoProyectadoRepository, $info))->getFile();
        $contrato = $this->contratoProyectadoRepository->find($info['id_contrato_proyectado']);

        try {
            return $this->response->array([
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($layout->string()),
                'name' => '# ' . str_pad($contrato->numero_folio, 5, '0', STR_PAD_LEFT) . '-AsignacionPresupuesto'
            ]);
        } catch (\ErrorException $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id_contrato_proyectado
     * @return mixed
     */
    public function carga_precios_asignacion_store(Request $request, $id_contrato_proyectado)
    {
        $rules = array(
            'file' => 'required',
        );

        $validator = app('validator')->make($request->all(), $rules);
        if (count($validator->errors()->all())) {
            throw new StoreResourceFailedException('No es posible cargar el Layout', $validator->errors());
        }

        $layout = (new AsignacionCargaPreciosLayout($this->contratoProyectadoRepository, []))
            ->setIdContratoProyectado($id_contrato_proyectado)
            ->qetDataFile($request);

        return $this->response->array($layout);
    }

    /**
     * @param Request $request
     * @param $id_requisicion
     * @return mixed
     */
    public function carga_precios_compras_asignacion(Request $request, $id_transaccion_sao)
    {
        // Obten la información de la requisción
        $req = $this->requisicionRepository->getRequisicion($id_transaccion_sao);

        $info = [
            'id_requisicion' => $req->idrqctoc_solicitudes,
            'id_transaccion_sao' => $id_transaccion_sao,
            'cot_ids' => is_string($request->ids) ? json_decode($request->ids, true): $request->ids,
            'agrupadores' => !empty($request->agrupadores) ? explode(',', $request->agrupadores) : [],
            'solo_pendientes' => $request->solo_pendientes
        ];

        $layout = (new AsignacionCargaProveedoresLayout($this->requisicionRepository, $info))->getFile();

        try {
            return $this->response->array([
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($layout->string()),
                'name' => '# ' . str_pad($req->folio_sao, 5, '0', STR_PAD_LEFT).'-AsignacionCotizacion'
            ]);
        } catch (\ErrorException $e) {
            dd($e->getMessage());
        }
    }

    public function carga_precios_compras_asignacion_store(Request $request, $id_requiscion)
    {
        $rules = array(
            'file' => 'required',
        );
        $validator =  app('validator')->make($request->all(), $rules);
        if (count($validator->errors()->all())) {
            throw new StoreResourceFailedException('No es posible cargar el Layout', $validator->errors());
        }

        $layout = (new AsignacionCargaProveedoresLayout($this->requisicionRepository,[]))
            ->setIdRequisicion($id_requiscion)
            ->qetDataFile($request);

        return $this->response->array($layout);
    }
}
