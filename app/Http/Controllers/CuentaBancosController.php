<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaBancosRepository;
use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Http\Requests;
use Illuminate\Support\Facades\DB;

class CuentaBancosController extends Controller
{
    public function __construct(CuentaBancosRepository $cuenta_bancos)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

//        $this->middleware('permission:consultar_cuenta_contable_bancaria', ['only' => ['index', 'show']]);
//        $this->middleware('permission:editar_cuenta_contable_bancaria', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:registrar_cuenta_contable_bancaria', ['only' => ['store']]);
//        $this->middleware('permission:eliminar_cuenta_contable_bancaria', ['only' => ['destroy']]);

        $this->cuenta_bancos = $cuenta_bancos;
    }

    public function index()
    {
        $dataView = [
            'cuentas' => Cuenta::paraTraspaso()->with('empresa')->get(),
        ];

        foreach ($dataView['cuentas'] as $c)
            $c->total_cuentas = $this->cuenta_bancos->getCount($c->id_cuenta);

        return view('sistema_contable.cuenta_bancos.index')
            ->with('dataView', $dataView);
    }

    /**
     * @param $id
     * @return $this
     */
    public function show($id)
    {
        $cuenta = Cuenta::paraTraspaso()->with('empresa')->find($id);
        $cuenta->cuentas_asociadas = $this->cuenta_bancos->with('tipoCuentaContable')->where(['id_cuenta', $id]);

        return view('sistema_contable.cuenta_bancos.show')->with('cuenta', $cuenta);
    }

    public function edit($id)
    {
        $cuenta = Cuenta::paraTraspaso()->with('empresa')->find($id);
        $tipos = $this->cuenta_bancos->tipos();

        return view('sistema_contable.cuenta_bancos.edit')->with('tipos', $tipos)->with('cuenta', $cuenta);
    }

    public function destroy(Request $request, $id)
    {
        $data = $request->all();
        $this->cuenta_empresa->delete($data, $id);
        $empresa = $this->empresa->with('cuentasEmpresa.tipoCuentaEmpresa')->find($data['data']['id_empresa']);
        return response()->json(['data' => ['empresa' => $empresa]], 200);

    }

    public function update(Request $request, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $data = $request->all();
            $cuenta = $this->cuenta_empresa->update($data, $id);
            $empresa = $this->empresa->with('cuentasEmpresa.tipoCuentaEmpresa')->find($data['data']['id_empresa']);

            $where = [
                ['id_tipo_cuenta_contable', '=', $cuenta->tipoCuentaEmpresa->id_tipo_cuenta_contable],
                ['id_empresa_cadeco', '=', $empresa->id_empresa],
            ];
            $movimientos = $this->poliza_movimiento->where($where)->all();
            $cambio_estatus = false;
            $id_poliza = 0;
            $poliza = null;
            foreach ($movimientos as $movimiento) {
                if ($movimiento->cuenta_contable == null) {
                    $poliza = $this->poliza->find($movimiento->id_int_poliza);
                    $id_poliza = $movimiento->id_int_poliza;
                    if ($poliza->estatus != 1 && $poliza->estatus != 2) {
                        $dataUpdate['cuenta_contable'] = $cuenta->cuenta;
                        $movUpdate = PolizaMovimiento::find($movimiento->id_int_poliza_movimiento);
                        $movUpdate->update($dataUpdate);
                        $cambio_estatus = true;
                    }
                }
            }

            if ($cambio_estatus) {
                $movimientos = PolizaMovimiento::where('id_poliza', '=', $id_poliza);
                $cuentas_completas = true;
                foreach ($movimientos as $movimiento) {
                    if ($movimiento->cuenta_contable == null) {
                        $cuentas_completas = false;
                    }
                }
                if ($cuentas_completas) {

                    if (abs($poliza->suma_debe - $poliza->suma_haber) <= .99) {
                        $dataUpdate['estatus'] = 0;
                        $poliza->update($dataUpdate);

                    }
                }
            }
            DB::connection('cadeco')->commit();
            return response()->json(['data' => ['empresa' => $empresa]], 200);

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }

    public function store(Request $request)
    {


        try {
            DB::connection('cadeco')->beginTransaction();
            $data = $request->all();
            $cambio_estatus = false;
            $poliza = null;
            $id_poliza = 0;
            $empresa = $this->empresa->find($data['id_empresa']);
            $cuenta = $this->cuenta_empresa->create($data);
            $where = [
                ['id_tipo_cuenta_contable', '=', $cuenta->tipoCuentaEmpresa->id_tipo_cuenta_contable],
                ['id_empresa_cadeco', '=', $empresa->id_empresa],
            ];
            $movimientos = $this->poliza_movimiento->where($where)->all();
            foreach ($movimientos as $movimiento) {
                if ($movimiento->cuenta_contable == null) {
                    $poliza = $this->poliza->find($movimiento->id_int_poliza);
                    $id_poliza = $movimiento->id_int_poliza;
                    if ($poliza->estatus != 1 && $poliza->estatus != 2) {
                        $dataUpdate['cuenta_contable'] = $cuenta->cuenta;
                        $movUpdate = PolizaMovimiento::find($movimiento->id_int_poliza_movimiento);
                        $movUpdate->update($dataUpdate);
                        $cambio_estatus = true;
                    }
                }
            }

            if ($cambio_estatus) {
                $movimientos = PolizaMovimiento::where('id_poliza', '=', $id_poliza);
                $cuentas_completas = true;
                foreach ($movimientos as $movimiento) {
                    if ($movimiento->cuenta_contable == null) {
                        $cuentas_completas = false;

                    }
                }
                if ($cuentas_completas) {
                    if (abs($poliza->suma_debe - $poliza->suma_haber) <= .99) {
                        $dataUpdate['estatus'] = 0;
                        $poliza->update($dataUpdate);
                    }
                }
            }

            DB::connection('cadeco')->commit();
            return response()->json(['data' => ['cuenta_empresa' => $cuenta]], 200);

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }
}
