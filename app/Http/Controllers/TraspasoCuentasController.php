<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoTransaccion;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoCuentas;
use Illuminate\Http\Request;
use Ghi\Domain\Core\Contracts\Tesoreria\TraspasoCuentasRepository;
use Ghi\Domain\Core\Contracts\Tesoreria\TraspasoTransaccionRepository;
use Illuminate\View\View;

class TraspasoCuentasController extends Controller
{
    /**
     *
     */
    public function __construct(TraspasoCuentasRepository $traspaso, TraspasoTransaccionRepository $traspaso_transaccion)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');

        // Permisos
        $this->middleware('permission:consultar_traspaso_cuenta', ['only' => ['index']]);
        $this->middleware('permission:eliminar_traspaso_cuenta', ['only' => ['destroy']]);
        $this->middleware('permission:editar_traspaso_cuenta', ['only' => ['update']]);

        $this->traspaso = $traspaso;
        $this->traspaso_transaccion = $traspaso_transaccion;
    }

    /**
     * @param Request $request
     * @internal param $Request
     * @return View
     */
    public function index(Request $request)
    {
        $dataView = [
            'cuentas' => Cuenta::paraTraspaso()->with('empresa')->get(),
            'traspasos' => $this->traspaso->with(['cuenta_destino.empresa', 'cuenta_origen.empresa', 'traspaso_transaccion.transaccion_debito'])->all(),
        ];

        return view('tesoreria.traspaso_cuentas.index')
            ->with('dataView', $dataView);
    }

    public function store(Request $request)
    {
        $id_obra = $request->session()->get('id');
        $create_data = $request->all();
        $create_data['id_obra'] = $id_obra;
        $record = $this->traspaso->create($create_data);

        // Si $record es un string hubo un error al guardar el traspaso
        return response()->json(['data' =>
            [
                'traspaso' => (is_string($record) ? $record : TraspasoCuentas::where('id_traspaso', '=', $record->id_traspaso)->with(['cuenta_destino.empresa', 'cuenta_origen.empresa', 'traspaso_transaccion.transaccion_debito'])->first())
            ]
        ], 200);
    }
    public function destroy($id)
    {
        $this->traspaso->delete($id);
        return response()->json(['data' =>
            [
                'id_traspaso' => $id
            ]
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $traspaso = $this->traspaso->update($request->all(), $id);

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
