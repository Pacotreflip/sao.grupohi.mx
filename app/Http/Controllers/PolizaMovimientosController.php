<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaEmpresaRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaMovimientoRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaEmpresaRepository;
use Ghi\Domain\Core\Models\Contabilidad\CuentaEmpresa;
use Ghi\Domain\Core\Models\Contabilidad\PolizaMovimiento;
use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaEmpresa;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class PolizaMovimientosController extends Controller
{

    /**
     * @var PolizaRepository
     */
    private $poliza;
    /**
     * @var PolizaMovimientoRepository
     */
    private $poliza_movimientos;

    /**
     * @var CuentaEmpresaRepository
     */
    private $cuenta_empresa;
    /**
     * @var TipoCuentaEmpresaRepository
     */
    private $tipo_cuenta_empresa;

    public function __construct(PolizaRepository $poliza, PolizaMovimientoRepository $poliza_movimientos, CuentaEmpresaRepository $cuenta_empresa, TipoCuentaEmpresaRepository $tipo_cuenta_empresa)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');

        $this->poliza = $poliza;
        $this->poliza_movimientos = $poliza_movimientos;
        $this->cuenta_empresa = $cuenta_empresa;
        $this->tipo_cuenta_empresa = $tipo_cuenta_empresa;

    }


    public function edit($idPoliza)
    {
        $where = [
            ['id_int_poliza', '=', $idPoliza]
        ];
        $movimientos = $this->poliza_movimientos->with(['empresaCadeco', 'tipoCuentaContable'])->where($where)->scope('notnull')->scope('ordered')->all();
        $movArray = $movimientos->filter(function ($movimiento) use ($movimientos) {
            $numveces = 0;
            foreach ($movimientos as $indexAux => $movimientoAux) {
                if ($movimiento->id_tipo_cuenta_contable == $movimientoAux->id_tipo_cuenta_contable) {
                    $numveces++;
                    unset($movimientos[$indexAux]);
                }
            }
            if ($numveces > 0) {
                return true;
            } else {
                return false;
            }

        })->values();

        return response()->json(['data' => ['movimientos' => $movArray]], 200);
    }

    public function update(Request $request, $idPoliza)
    {
        $cambios = [];
        $validar = $request->all()['validar'];
        if ($validar == 'true') {
            foreach ($request->all()['data'] as $item) {
                $tipo_cta_empresa = $this->tipo_cuenta_empresa->where([['id_tipo_cuenta_contable', '=', $item['id_tipo_cuenta_contable']]])->all();
                if (count($tipo_cta_empresa) > 0) {
                    foreach ($tipo_cta_empresa as $cta_empresa) {
                        $where = [
                            ['id_empresa', '=', $item['empresa_cadeco']['id_empresa']],
                            ['id_tipo_cuenta_empresa', '=', $cta_empresa->id]
                        ];
                        $cuentas_empresas = $this->cuenta_empresa->with('tipoCuentaEmpresa')->where($where)->all();
                        foreach ($cuentas_empresas as $cta_empresa) {
                            if ($cta_empresa->cuenta != $item['cuenta_contable']) {
                                $cta_empresa['nuevo'] = $item['cuenta_contable'];
                                array_push($cambios, $cta_empresa);
                            }
                        }
                    }
                }
            }
            if (count($cambios) > 0) {
                return response()->json(['data' => ['cambio' => $cambios]], 200);
            }
        }

        foreach ($request->all()['data'] as $item) {
            /////////// obtener tipo de cuenta
            $tipos_ctas_empresas = TipoCuentaEmpresa::where([['id_tipo_cuenta_contable', '=', $item['tipo_cuenta_contable']['id_tipo_cuenta_contable']]])->get();


            if (count($tipos_ctas_empresas) > 0) {


                foreach ($tipos_ctas_empresas as $cta_empresa) {
                    $tipo_cta_empresa = $cta_empresa;
                }
            } else {


                $dataCtaInsert['descripcion'] = $item['tipo_cuenta_contable']['descripcion'];
                $dataCtaInsert['id_tipo_cuenta_contable'] = $item['tipo_cuenta_contable']['id_tipo_cuenta_contable'];

                $tipo_cta_empresa = TipoCuentaEmpresa::create($dataCtaInsert);
            }

            $where = [
                ['id_empresa', '=', $item['empresa_cadeco']['id_empresa']],
                ['id_tipo_cuenta_empresa', '=', $tipo_cta_empresa->id]
            ];

            /////////////////// buscar la cuenta de la empresa con el idtipo cuenta empresa
            $cuentas_empresas = $this->cuenta_empresa->where($where)->all();


            if (count($cuentas_empresas) > 0) { ///actualizo cuenta_empresa

                foreach ($cuentas_empresas as $cuentaEmp) {
                    $cuentas_empresas = CuentaEmpresa::find($cuentaEmp->id);
                    $cuentas_empresas->cuenta = $item['cuenta_contable'];
                    $cuentas_empresas->save();

                }

            } else { //////inserto cuenta_empresa
                $dataInsert['id_empresa'] = $item['empresa_cadeco']['id_empresa'];
                $dataInsert['id_tipo_cuenta_empresa'] = $tipo_cta_empresa->id;
                $dataInsert['cuenta'] = $item['cuenta_contable'];
                CuentaEmpresa::create($dataInsert);
            }
            //////////////Actualizo el movimiento
            $where = [
                ['id_int_poliza', '=', $idPoliza],
                ['id_tipo_cuenta_contable', '=', $item['tipo_cuenta_contable']['id_tipo_cuenta_contable']]
            ];
            $movimientoUpd = PolizaMovimiento::where($where)->get();
            foreach ($movimientoUpd as $movUp) {
                $PolMov = PolizaMovimiento::find($movUp->id_int_poliza_movimiento);
                $PolMov->cuenta_contable = $item['cuenta_contable'];
                $PolMov->save();
            }
            $movimiento = $this->poliza_movimientos->find($item['id_int_poliza_movimiento']);


        }

        $poliza = $this->poliza->find($idPoliza);
        $movimientos = PolizaMovimiento::where('id_poliza', '=', $idPoliza);
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


        $poliza = $this->poliza->with('polizaMovimientos.tipoCuentaContable')->find($idPoliza);
        return response()->json(['data' => ['poliza' => $poliza]], 200);
    }
}
