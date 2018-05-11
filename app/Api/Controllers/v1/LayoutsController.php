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
use Dotenv\Validator;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Contracts\ContratoProyectadoRepository;
use Ghi\Domain\Core\Layouts\Compras\Asignacion;
use Ghi\Domain\Core\Layouts\Compras\AsignacionProveedoresLayout;
use Ghi\Domain\Core\Layouts\Contratos\AsignacionSubcontratistasLayout;
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

    public function compras_asignacion(Request $request, $id_requisicion)
    {
        $requisicion = $this->requisicionRepository->find($id_requisicion);
        $layout = (new AsignacionProveedoresLayout($requisicion))->getFile();

        try {
            return $this->response->array([
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($layout->string()),
                'name' => '# ' . str_pad($requisicion->numero_folio, 5, '0', STR_PAD_LEFT).'-AsignacionProveedores'
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
            'file' => 'required',
        );
        $messages = [
            'file.required' => 'Selecciona al menos archvio.',
            'file.mimes' => 'No puedes utilizar ese tipo de imagen, intenta con (xlsx).',
            'file.max' => 'El total de imagenes no puede pesar mas de 3MB.'
        ];

        $validator = Validator::make($request, $rules, $messages);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new user.', $validator->errors());
        }
        $requisicion = $this->requisicionRepository->find($id_requisicion);
        $layout = (new AsignacionProveedoresLayout($requisicion))->qetDataFile($request);
        return $this->response->array($layout);
    }

    public function contratos_asignacion(Request $request, $id_contrato_proyectado)
    {
        $contrato_proyectado = $this->contratoProyectadoRepository->find($id_contrato_proyectado);
        $layout = (new AsignacionSubcontratistasLayout($contrato_proyectado))->getFile();

        try {
            return $this->response->array([
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($layout->string()),
                'name' => '# ' . str_pad($contrato_proyectado->numero_folio, 5, '0', STR_PAD_LEFT).'-AsignacionContratistas'
            ]);
        } catch (\ErrorException $e) {
        }
    }

    public function contratos_asignacion_store(Request $request, $id_contrato_proyectado)
    {
        $rules = array(
            'file' => 'required',
        );
        $messages = [
            'file.required' => 'Selecciona al menos archvio.',
            'file.mimes' => 'No puedes utilizar ese tipo de imagen, intenta con (xlsx).',
            'file.max' => 'El total de imagenes no puede pesar mas de 3MB.'
        ];

        $validator = Validator::make($request, $rules, $messages);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new user.', $validator->errors());
        }
        
        $contrato_proyectado = $this->contratoProyectadoRepository->find($id_contrato_proyectado);
        $layout = (new AsignacionSubcontratistasLayout($contrato_proyectado))->qetDataFile($request);

        return $this->response->array($layout);
    }
}
