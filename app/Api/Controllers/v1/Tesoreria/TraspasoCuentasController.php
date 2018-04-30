<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 11/04/2018
 * Time: 09:06 AM
 */

namespace Ghi\Api\Controllers\v1\Tesoreria;

use Ghi\Domain\Core\Contracts\Tesoreria\TraspasoCuentasRepository;
use Ghi\Domain\Core\Contracts\Tesoreria\TraspasoTransaccionRepository;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoTransaccion;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoCuentas;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Http\Controllers\Controller as BaseController;
use Dingo\Api\Http\Request;
use JWTAuth;


class TraspasoCuentasController extends BaseController
{
    /**
     * @var TraspasoCuentasRepository
     */
    protected $traspasoCuentas;
    /**
     * @var TraspasoTransaccionRepository
     */
    protected $traspasoTransaccion;

    /**
     * TraspasoCuentasController constructor.
     * @param TraspasoCuentasRepository $traspasoCuentas
     */
    public function __construct(TraspasoCuentasRepository $traspasoCuentas, TraspasoTransaccionRepository $traspasoTransaccion)
    {
        $this->traspasoCuentas = $traspasoCuentas;
        $this->traspasoTransaccion = $traspasoTransaccion;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request){
        $resp = $this->traspasoCuentas->paginate($request->all());
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
            $payload = JWTAuth::parseToken()->getPayload();
            $id_obra = $payload->get('id_obra');
            $create_data = $request->all();
            $create_data['id_obra'] = $id_obra;
            $create_data['folio'] = $request->get('referencia');
            $record = $this->traspasoCuentas->create($create_data);
            // Si $record es un string hubo un error al guardar el traspaso
            return response()->json(['data' =>
                [
                    'traspaso' => (is_string($record) ? $record : $this->traspasoCuentas
                        ->with(['cuenta_destino.empresa', 'cuenta_origen.empresa', 'traspaso_transaccion.transaccion_debito'])
                        ->find($record->id_traspaso)
                    )
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
            return response()->json(['data' => $this->traspasoCuentas
                ->with(['cuenta_destino.empresa', 'cuenta_origen.empresa', 'traspaso_transaccion.transaccion_debito'])
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
            $this->traspasoCuentas->delete($id);
            return response()->json(['data' =>
                [
                    'id_traspaso' => $id
                ]
            ], 200);
        }  catch (\Exception $e){
            return response()->json([
                'data' => $e->getTraceAsString()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $traspaso = $this->traspasoCuentas->update($request->all(), $id);

        // Obtener el id de las transacciones a editar
        $transacciones = TraspasoTransaccion::where('id_traspaso', '=', $id)->get();

        foreach ($transacciones as $tr)
            Transaccion::where('id_transaccion', $tr->id_transaccion)
                ->update([
                    'fecha' => $request->get('fecha'),
                    'vencimiento' => $request->get('vencimiento'),
                    'cumplimiento' =>$request->get('cumplimiento'),
                    'referencia' => $request->get('referencia'),
                ]);

        return response()->json(['data' =>
            [
                'traspaso' => TraspasoCuentas::where('id_traspaso', '=', $traspaso->id_traspaso)->with(['cuenta_destino.empresa', 'cuenta_origen.empresa', 'traspaso_transaccion.transaccion_debito'])->first()
            ]
        ], 200);
    }
}