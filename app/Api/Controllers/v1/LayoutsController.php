<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/04/2018
 * Time: 01:00 PM
 */

namespace Ghi\Api\Controllers\v1;


use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Layouts\Compras\Asignacion;
use Ghi\Domain\Core\Layouts\Compras\AsignacionProveedoresLayout;
use Ghi\Http\Controllers\Controller as BaseController;
use Maatwebsite\Excel\Facades\Excel;

class LayoutsController extends BaseController
{
    use Helpers;

    /**
     * @var RequisicionRepository
     */
    protected $requisicionRepository;

    /**
     * LayoutsController constructor.
     * @param RequisicionRepository $requisicionRepository
     */
    public function __construct(RequisicionRepository $requisicionRepository)
    {
        $this->requisicionRepository = $requisicionRepository;
    }

    public function compras_asignacion(Request $request, $id_requisicion) {
        $requisicion = $this->requisicionRepository->find($id_requisicion);
        $layout = (new AsignacionProveedoresLayout($requisicion))->getFile();

        return $this->response->array([
            'file' => "data:application/vnd.ms-excel;base64,".base64_encode($layout->string()),
            'name'   => 'AsignacionProveedores'
        ]);
    }

    /**
     * @param Request $request
     * @param $id_requisicion
     * @return mixed
     */
    public function compras_asignacion_store(Request $request, $id_requisicion)
    {
        $requisicion = $this->requisicionRepository->find($id_requisicion);
        $layout = (new AsignacionProveedoresLayout($requisicion))->setData($request);
        return $this->response->array([
            'file' => "data:application/vnd.ms-excel;base64,".base64_encode($layout->string()),
            'name'   => 'AsignacionProveedores'
        ]);
    }
}