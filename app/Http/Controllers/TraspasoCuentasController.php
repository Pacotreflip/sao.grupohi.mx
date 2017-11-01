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
        $this->transaccion = new Transaccion;
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
        $obras = $this->traspaso->obras();
        $id_obra = $request->session()->get('id');
        $create_data = $request->all();
        $create_data['id_obra'] = $id_obra;
        $record = $this->traspaso->create($create_data);
        $id_moneda = 0;

        // Crear el nuevo folio de acuerdo con el id de la obra
        $folio = TraspasoCuentas::where('id_obra', $id_obra)->max('numero_folio');
        $folio = (int) $folio + 1;

        TraspasoCuentas::where('id_traspaso', $record->id_traspaso)
            ->update([
                'numero_folio' => $folio,
            ]);

        foreach ($obras as $o)
            if ($o->id_obra == $id_obra)
                $id_moneda = $o->id_moneda;

        $credito = [
            'tipo_transaccion' => 83,
            'fecha' => $request->input('fecha') ? $request->input('fecha') : date('Y-m-d'),
            'estado' => 1,
            'id_obra' => $id_obra,
            'id_cuenta' => $request->input('id_cuenta_destino'),
            'id_moneda' => $id_moneda,
            'cumplimiento' => $request->input('cumplimiento') ? $request->input('cumplimiento') : date('Y-m-d'),
            'vencimiento' => $request->input('vencimiento') ? $request->input('vencimiento') : date('Y-m-d'),
            'opciones' => 1,
            'monto' => $request->input('importe'),
            'referencia' => $request->input('referencia'),
            'comentario' => "I;". date("d/m/Y") ." ". date("h:s") .";". auth()->user()->usuario,
            'observaciones' => $request->input('observaciones'),
            'FechaHoraRegistro' => date('Y-m-d h:i:s'),
        ];

        $debito = $credito;
        $debito['tipo_transaccion'] = 84;
        $debito['id_cuenta'] = $request->input('id_cuenta_origen');
        $debito['monto'] = '-'. $request->input('importe');

       // Crear transaccion Débito
        $transaccion_debito = $this->transaccion->create($debito);

       // Crear transaccion Crédito
        $transaccion_credito = $this->transaccion->create($credito);

        // Enlaza las transacciones con su respectivo traspaso. Debito
        TraspasoTransaccion::create([
            'id_traspaso' => $record->id_traspaso,
            'id_transaccion' => $transaccion_debito->id_transaccion,
            'tipo_transaccion' => $debito['tipo_transaccion'],
        ]);

        // Enlaza las transacciones con su respectivo traspaso. Credito
        TraspasoTransaccion::create([
            'id_traspaso' => $record->id_traspaso,
            'id_transaccion' => $transaccion_credito->id_transaccion,
            'tipo_transaccion' => $credito['tipo_transaccion'],
        ]);

        return response()->json(['data' =>
            [
                'traspaso' => TraspasoCuentas::where('id_traspaso', '=', $record->id_traspaso)->with(['cuenta_destino.empresa', 'cuenta_origen.empresa', 'traspaso_transaccion.transaccion_debito'])->first()
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
