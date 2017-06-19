<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\TipoCuentaContableRepository;
use Illuminate\Http\Request;

class TipoCuentaContableController extends Controller
{
    use Helpers;

    /**
     * @var TipoCuentaContableRepository
     */
    private $tipo_cuenta_contable;

    public function __construct(
        TipoCuentaContableRepository $tipo_cuenta_contable)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->tipo_cuenta_contable = $tipo_cuenta_contable;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos_cuenta_contable = $this->tipo_cuenta_contable->all();
        //dd($tipos_cuenta_contable);
        return view('modulo_contable.tipo_cuenta_contable.index')
            ->with('tipos_cuenta_contable', $tipos_cuenta_contable);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipo_cuenta_contable = $this->tipo_cuenta_contable->find($id);
        // TODO: Add return statement
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = $this->tipo_cuenta_contable->create($request->all());
        // TODO: Add return statement
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->tipo_cuenta_contable->delete($request->only('motivo'), $id);
        return $this->response()->accepted();
    }
}
