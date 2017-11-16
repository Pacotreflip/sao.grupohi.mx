<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaBancosRepository;
use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaContable;
use Ghi\Domain\Core\Models\Contabilidad\CuentaBancos;
use Ghi\Domain\Core\Models\Cuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuentaBancosController extends Controller
{
    public function __construct(CuentaBancosRepository $cuenta_bancos)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:consultar_cuenta_contable_bancaria', ['only' => ['index', 'show']]);
        $this->middleware('permission:editar_cuenta_contable_bancaria', ['only' => ['edit', 'update']]);
        $this->middleware('permission:registrar_cuenta_contable_bancaria', ['only' => ['store']]);
        $this->middleware('permission:eliminar_cuenta_contable_bancaria', ['only' => ['destroy']]);

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
        $cuenta->cuentas_asociadas = CuentaBancos::with('tipoCuentaContable')->where(['id_cuenta' => $id, 'estatus' => 1])->get();

        return view('sistema_contable.cuenta_bancos.show')->with('cuenta', $cuenta);
    }

    public function edit($id)
    {
        $cuenta = Cuenta::paraTraspaso()->with('empresa')->find($id);
        $tipos = TipoCuentaContable::where('tipo', 5)->get();
        $cuentas_asociadas = CuentaBancos::with('tipoCuentaContable')->where(['id_cuenta' => $id, 'estatus' => 1])->get();

        return view('sistema_contable.cuenta_bancos.edit')->with('tipos', $tipos)->with('cuenta', $cuenta)->with('cuentas_asociadas', $cuentas_asociadas);
    }

    public function destroy(Request $request, $id)
    {
        $data = $request->all();

        $this->cuenta_bancos->delete($data, $id);

        return response()->json(['data' => 'ok'], 200);

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $item = $this->cuenta_bancos->update($data, $id);

        return response()->json(['data' => $item], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $item = $this->cuenta_bancos->create($data);

        return response()->json(['data' => $item], 200);
    }
}
