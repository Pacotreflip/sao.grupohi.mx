<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaEmpresaRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaMovimientoRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaEmpresaRepository;
use Ghi\Domain\Core\Contracts\EmpresaRepository;
use Ghi\Domain\Core\Models\Contabilidad\MovimientoPoliza;
use Ghi\Domain\Core\Models\Contabilidad\Poliza;
use Ghi\Domain\Core\Models\Contabilidad\PolizaMovimiento;
use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaEmpresa;
use Illuminate\Http\Request;

use Ghi\Http\Requests;
use Illuminate\Support\Facades\DB;

class CuentaEmpresaController extends Controller
{

    /**
     * @var Cuenta
     */
    private $cuenta_empresa;
    /**
     * @var Empresa
     */
    private $empresa;
    /**
     * @var TipoCuentaEmpresa
     */
    private $tipo_cuenta_empresa;
    /**
     * @var poliza
     */
    private $poliza_movimiento;
    /**
     * @var poliza
     */
    private $poliza;

    public function __construct(CuentaEmpresaRepository $cuenta_empresa, EmpresaRepository $empresa, TipoCuentaEmpresaRepository $tipo_cuenta_empresa, PolizaMovimientoRepository $poliza_movimiento, PolizaRepository $poliza)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:consultar_cuenta_empresa', ['only' => ['index', 'show']]);
        $this->middleware('permission:editar_cuenta_empresa', ['only' => ['edit', 'update']]);
        $this->middleware('permission:registrar_cuenta_empresa', ['only' => ['store']]);
        $this->middleware('permission:eliminar_cuenta_empresa', ['only' => ['destroy']]);

        $this->cuenta_empresa = $cuenta_empresa;
        $this->empresa = $empresa;
        $this->tipo_cuenta_empresa = $tipo_cuenta_empresa;
        $this->poliza_movimiento = $poliza_movimiento;
        $this->poliza = $poliza;

    }

    /**
     * Muestra la vista del listado de Ceuntas de Empresar registradas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $empresas = $this->empresa->with('cuentasEmpresa')->all();

        return view('sistema_contable.cuenta_empresa.index')
            ->with('empresas', $empresas);
    }

    public function show($id)
    {
        $empresa = $this->empresa->with('cuentasEmpresa')->find($id);
        return view('sistema_contable.cuenta_empresa.show')->with('empresa', $empresa);
    }

    public function edit($id)
    {
        $empresa = $this->empresa->with('cuentasEmpresa.tipoCuentaEmpresa')->find($id);
        $tipoCuentaEmpresa = $this->tipo_cuenta_empresa->all();
        return view('sistema_contable.cuenta_empresa.edit')->with('empresa', $empresa)->with('tipo_cuenta_empresa', $tipoCuentaEmpresa);
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
