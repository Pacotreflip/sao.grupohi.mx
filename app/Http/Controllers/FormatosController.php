<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\EmpresaRepository;
use Ghi\Domain\Core\Contracts\EstimacionRepository;
use Ghi\Domain\Core\Formatos\Subcontratos\Estimacion;

class FormatosController extends Controller
{

    protected $estimacion;
    protected $empresa;

    /**
     * FormatosController constructor.
     * @param EstimacionRepository $estimacion
     * @param EmpresaRepository $empresa
     */
    public function __construct(EstimacionRepository $estimacion, EmpresaRepository $empresa)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:consultar_formato_estimacion', ['only' => ['estimacion_pdf', 'estimacion']]);
        $this->middleware('permission:consultar_formato_comparativa_presupuestos', ['only' => ['comparativa_presupuestos']]);

        $this->estimacion = $estimacion;
        $this->empresa = $empresa;

    }

    public function estimacion_pdf($id)
    {
        $estimacion = $this->estimacion->find($id);
        $pdf = new Estimacion($estimacion);
        $pdf->create();
    }

    public function estimacion() {
        $empresas = $this->empresa->scope('Subcontratos')->all();
        return view('formatos.subcontratos.estimacion')
            ->withEmpresas($empresas);
    }

    public function comparativa_presupuestos() {
        return view('formatos.subcontratos.comparativa_presupuestos');
    }
}
