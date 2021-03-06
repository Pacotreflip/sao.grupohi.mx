<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaContableRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaMovimientoRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaContableRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TransaccionesInterfazRepository;
use Ghi\Domain\Core\Contracts\GraficasRepository;
use Ghi\Domain\Core\Models\Contabilidad\EstatusPrePoliza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolizaController extends Controller
{
    use Helpers;

    protected $poliza;
    protected $tipoCuentaContable;
    protected $cuenta_contable;
    protected $transaccion_interfaz;
    protected $poliza_movimientos;
    protected $graficas;

    public function __construct(PolizaRepository $poliza, TipoCuentaContableRepository $tipoCuenta, CuentaContableRepository $cuenta_contable, TransaccionesInterfazRepository $transaccion_interfaz, PolizaMovimientoRepository $poliza_movimientos,GraficasRepository $graficas)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:consultar_prepolizas_generadas', ['only' => ['index', 'show']]);
        $this->middleware('permission:editar_prepolizas_generadas', ['only' => ['edit', 'update', 'ingresarFolio']]);

        $this->poliza = $poliza;
        $this->tipoCuentaContable = $tipoCuenta;
        $this->cuenta_contable = $cuenta_contable;
        $this->transaccion_interfaz = $transaccion_interfaz;
        $this->poliza_movimientos = $poliza_movimientos;
        $this->graficas=$graficas;
    }

    public function index(Request $request)
    {
        $tipo_polizas = $this->transaccion_interfaz->scope('ocupadas')->all();
        $est_prepolizas = EstatusPrePoliza::orderBy('descripcion')->lists('descripcion', 'estatus');

        return view('sistema_contable.poliza_generada.index')
            ->with('fechas', $request->fechas)
            ->with('estatus', $request->estatus)
            ->with('tipo', $request->tipo)
            ->with('tipo_polizas', $tipo_polizas)
            ->with('est_prepolizas', $est_prepolizas);
    }

    public function paginate(Request $request)
    {
        $polizas = '';
        if ($request->has('fechas') && $request->has('estatus') && $request->has('tipo')) {

            $fecha_inicial = explode(" - ", $request->fechas)[0] . ' 00:00:00.000';
            $fecha_final = explode(" - ", $request->fechas)[1] . ' 00:00:00.000';
            $where = [
                ['Contabilidad.int_polizas.fecha', 'between', DB::raw("'{$fecha_inicial}' and '{$fecha_final}'")],
                ['Contabilidad.int_polizas.estatus', '=', $request->estatus],
                ['Contabilidad.int_polizas.id_tipo_poliza_interfaz', '=', $request->tipo]
            ];

            $polizas = $this->poliza->with(['transaccionInterfaz', 'tipoPolizaContpaq', 'estatusPrepoliza', 'historicos'])->where($where)->paginate($request->all());
        } elseif ($request->has('fechas') && $request->has('tipo')) {

            $fecha_inicial = explode(" - ", $request->fechas)[0] . ' 00:00:00.000';
            $fecha_final = explode(" - ", $request->fechas)[1] . ' 00:00:00.000';
            $where = [
                ['Contabilidad.int_polizas.fecha', 'between', DB::raw("'{$fecha_inicial}' and '{$fecha_final}'")],
                ['Contabilidad.int_polizas.id_tipo_poliza_interfaz', '=', $request->tipo]
            ];

            $polizas = $this->poliza->with(['transaccionInterfaz', 'tipoPolizaContpaq', 'estatusPrepoliza', 'historicos'])->where($where)->paginate($request->all());
        }
        elseif ($request->has('fechas') && $request->has('estatus')) {

            $fecha_inicial = explode(" - ", $request->fechas)[0] . ' 00:00:00.000';
            $fecha_final = explode(" - ", $request->fechas)[1] . ' 00:00:00.000';
            $where = [
                ['Contabilidad.int_polizas.fecha', 'between', DB::raw("'{$fecha_inicial}' and '{$fecha_final}'")],
                ['Contabilidad.int_polizas.estatus', '=', $request->estatus]
            ];

            $polizas = $this->poliza->with(['transaccionInterfaz', 'tipoPolizaContpaq', 'estatusPrepoliza', 'historicos'])->where($where)->paginate($request->all());
        }
        elseif ($request->estatus != "" && $request->tipo != "") {
            $where = [
                ['Contabilidad.int_polizas.estatus', '=', $request->estatus],
                ['Contabilidad.int_polizas.id_tipo_poliza_interfaz', '=', $request->tipo]
            ];


            $polizas = $this->poliza->with(['transaccionInterfaz', 'tipoPolizaContpaq', 'estatusPrepoliza', 'historicos'])->where($where)->paginate($request->all());
        } elseif ($request->estatus != "") {
            $where = [
                ['Contabilidad.int_polizas.estatus', '=', $request->estatus]
            ];


            $polizas = $this->poliza->with(['transaccionInterfaz', 'tipoPolizaContpaq', 'estatusPrepoliza', 'historicos'])->where($where)->paginate($request->all());
        } elseif ($request->tipo > 0) {
            $where = [
                ['Contabilidad.int_polizas.id_tipo_poliza_interfaz', '=', $request->tipo]
            ];


            $polizas = $this->poliza->with(['transaccionInterfaz', 'tipoPolizaContpaq', 'estatusPrepoliza', 'historicos'])->where($where)->paginate($request->all());
        } elseif ($request->fechas) {
            $fecha_inicial = explode(" - ", $request->fechas)[0] . ' 00:00:00.000';
            $fecha_final = explode(" - ", $request->fechas)[1] . ' 00:00:00.000';
            $where = [
                ['Contabilidad.int_polizas.fecha', 'between', DB::raw("'{$fecha_inicial}' and '{$fecha_final}'")]
            ];

            $polizas = $this->poliza->with(['transaccionInterfaz', 'tipoPolizaContpaq', 'estatusPrepoliza', 'historicos'])->where($where)->paginate($request->all());
        } else {
            $polizas = $this->poliza->with(['transaccionInterfaz', 'tipoPolizaContpaq', 'estatusPrepoliza', 'historicos'])->paginate($request->all());
        }

        return response()->json([
            'recordsTotal' => $polizas->total(),
            'recordsFiltered' => $polizas->total(),
            'data' => $polizas->items()
        ], 200);
    }

    public function show($id)
    {
        $polizas = $this->poliza->with('polizaMovimientos')->find($id);
        return view('sistema_contable.poliza_generada.show')->with('poliza', $polizas);
    }

    public function edit($id)
    {
        $movimientos = $this->poliza_movimientos->with(['empresaCadeco', 'tipoCuentaContable'])->where([['id_int_poliza', '=', $id]])->scope('notnull')->scope('ordered')->all();
        $movArray = $movimientos->filter(function ($movimiento) use ($movimientos) {
            $numveces = 0;
            foreach ($movimientos as $indexAux => $movimientoAux) {
                if ($movimiento->id_tipo_cuenta_contable == $movimientoAux->id_tipo_cuenta_contable) {
                    $numveces++;
                    unset($movimientos[$indexAux]);
                }
            }
            return $numveces > 0;
        })->values();


        $tipoCuentaContable = $this->tipoCuentaContable->with('cuentaContable')->lists();
        $poliza = $this->poliza->with('polizaMovimientos.tipoCuentaContable')->find($id);
        $cuentasContables = $this->cuenta_contable->all();
        return view('sistema_contable.poliza_generada.edit')
            ->with('poliza', $poliza)
            ->with('tipoCuentaContable', $tipoCuentaContable)
            ->with('cuentasContables', $cuentasContables)
            ->with('movimientosCuenta', $movArray);
    }

    public function update(Request $request, $id)
    {
        $item = $this->poliza->update($request->all(), $id);
        return $this->response->created(route('sistema_contable.poliza_generada.show', $item));
    }

    public function ingresarFolio(Request $request, $id)
    {

        $item = $this->poliza->ingresarFolio($request->all(), $id);
        return $this->response->created(route('sistema_contable.poliza_generada.show', $item));
    }
}
