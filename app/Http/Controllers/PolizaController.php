<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaContableRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaContableRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TransaccionesInterfazRepository;
use Ghi\Domain\Core\Models\Contabilidad\Poliza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolizaController extends Controller
{
    use Helpers;

    protected $poliza;
    protected $tipoCuentaContable;
    protected $cuenta_contable;
    protected $transaccion_interfaz;

    public function __construct(PolizaRepository $poliza, TipoCuentaContableRepository $tipoCuenta, CuentaContableRepository $cuenta_contable, TransaccionesInterfazRepository $transaccion_interfaz)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:consultar_prepolizas_generadas', ['only' => ['index', 'show']]);
        $this->middleware('permission:editar_prepolizas_generadas', ['only' => ['edit', 'update']]);

        $this->poliza = $poliza;
        $this->tipoCuentaContable = $tipoCuenta;
        $this->cuenta_contable = $cuenta_contable;
        $this->transaccion_interfaz = $transaccion_interfaz;
    }

    public function index(Request $request)
    {

        if ($request->has('fechas') && $request->has('estatus') && $request->has('tipo')) {

            $fecha_inicial = explode(" - ", $request->fechas)[0] . ' 00:00:00.000';
            $fecha_final = explode(" - ", $request->fechas)[1] . ' 00:00:00.000';
            $where = [
                ['fecha', 'between', DB::raw("'{$fecha_inicial}' and '{$fecha_final}'")],
                ['estatus', '=', $request->estatus],
                ['id_tipo_poliza_interfaz', '=', $request->tipo]
            ];

            $polizas = $this->poliza->where($where)->paginate(800);
        }
        elseif ($request->has('fechas')&&$request->has('tipo')) {

            $fecha_inicial = explode(" - ", $request->fechas)[0] . ' 00:00:00.000';
            $fecha_final = explode(" - ", $request->fechas)[1] . ' 00:00:00.000';
            $where = [
                ['fecha', 'between', DB::raw("'{$fecha_inicial}' and '{$fecha_final}'")],
                ['id_tipo_poliza_interfaz', '=', $request->tipo]
            ];

            $polizas = $this->poliza->where($where)->paginate(800);
        }
        elseif ($request->estatus != ""&& $request->tipo != "") {
            $where = [
                ['estatus', '=', $request->estatus],
                ['id_tipo_poliza_interfaz', '=', $request->tipo]
            ];


            $polizas = $this->poliza->where($where)->paginate(800);
        }
        elseif ($request->estatus != "") {
            $where = [
                ['estatus', '=', $request->estatus]
            ];


            $polizas = $this->poliza->where($where)->paginate(800);
        }
        elseif ($request->tipo>0) {
            $where = [
                ['id_tipo_poliza_interfaz', '=', $request->tipo]
            ];


            $polizas = $this->poliza->where($where)->paginate(800);
        }
        elseif ($request->fechas) {
            $fecha_inicial = explode(" - ", $request->fechas)[0] . ' 00:00:00.000';
            $fecha_final = explode(" - ", $request->fechas)[1] . ' 00:00:00.000';
            $where = [
                ['fecha', 'between', DB::raw("'{$fecha_inicial}' and '{$fecha_final}'")]
            ];


            $polizas = $this->poliza->where($where)->paginate(800);
        } else {
            $polizas = $this->poliza->paginate(800);

        }
        $tipo_polizas = $this->transaccion_interfaz->all();
        return view('sistema_contable.poliza_generada.index')
            ->with('polizas', $polizas)
            ->with('fechas', $request->fechas)
            ->with('estatus', $request->estatus)
            ->with('tipo',$request->tipo)
            ->with('tipo_polizas', $tipo_polizas);

    }

    public function show($id)
    {
        $polizas = $this->poliza->with('polizaMovimientos')->find($id);
        return view('sistema_contable.poliza_generada.show')->with('poliza', $polizas);
    }

    public function edit($id)
    {

        $tipoCuentaContable = $this->tipoCuentaContable->with('cuentaContable')->lists();
        $poliza = $this->poliza->with('polizaMovimientos.tipoCuentaContable')->find($id);
        $cuentasContables = $this->cuenta_contable->all();

        return view('sistema_contable.poliza_generada.edit')->with('poliza', $poliza)->with('tipoCuentaContable', $tipoCuentaContable)->with('cuentasContables', $cuentasContables);
    }

    public function update(Request $request, $id)
    {
        $item = $this->poliza->update($request->all(), $id);
        return $this->response->created(route('sistema_contable.poliza_generada.show', $item));
    }
}
