<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 17/04/2018
 * Time: 11:37 PM
 */

namespace Ghi\Api\Controllers\v1\Tesoreria;

use Ghi\Domain\Core\Contracts\Tesoreria\MovimientosBancariosRepository;
use Ghi\Http\Controllers\Controller as BaseController;
use Dingo\Api\Http\Request;
use JWTAuth;

class MovimientosBancariosController  extends BaseController
{
    /**
     * @var MovimientosBancariosRepository
     */
    private $movimientosBancarios;

    /**
     * @param MovimientosBancariosRepository $movimientos
     */
    public function __construct(MovimientosBancariosRepository $movimientosBancarios)
    {
        $this->movimientosBancarios = $movimientosBancarios;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request){
        $resp = $this->movimientosBancarios->paginate($request->all());
        return response()->json([
            'recordsTotal' => $resp->total(),
            'recordsFiltered' => $resp->total(),
            'data' => $resp->items()], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        try {
            $record = $this->movimientosBancarios->create($request->all());

            return response()->json(['data' =>
                [
                    'movimiento' => $record
                ]
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'data' => $e->getTraceAsString()], 500);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {

            // Si $record es un string hubo un error al guardar el traspaso
            return response()->json(['data' => $this->movimientosBancarios
                ->with(['tipo', 'cuenta.empresa', 'movimiento_transaccion.transaccion'])
                ->find($id) ], 200);
        } catch (\Exception $e){
            return response()->json([
                'data' => $e->getTraceAsString()], 500);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        try {
            $this->movimientosBancarios->delete($id);

            return response()->json(['data' =>
                [
                    'id_movimiento_bancario' => $id
                ]
            ], 200);
        }  catch (\Exception $e){
            return response()->json([
                'data' => $e->getTraceAsString()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $movimiento = $this->movimientosBancarios->update($request->all(), $id);

        return response()->json(['data' =>
            [
                'movimiento' => $movimiento
            ]
        ], 200);
    }
}