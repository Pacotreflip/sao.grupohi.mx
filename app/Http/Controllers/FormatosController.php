<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Contracts\ContratoProyectadoRepository;
use Ghi\Domain\Core\Contracts\EmpresaRepository;
use Ghi\Domain\Core\Contracts\EstimacionRepository;
use Ghi\Domain\Core\Formatos\Compras\ComparativaCotizacionesCompra;
use Ghi\Domain\Core\Formatos\Contratos\ComparativaCotizacionesContrato;
use Ghi\Domain\Core\Formatos\Finanzas\PDFSolicitudRecursos;
use Ghi\Domain\Core\Formatos\Subcontratos\Estimacion;
use Ghi\Domain\Core\Models\Finanzas\SolicitudRecursos;

class FormatosController extends Controller
{

    protected $estimacion;
    protected $empresa;
    protected $contratoProyectado;
    protected $requisicion;

    /**
     * FormatosController constructor.
     * @param EstimacionRepository $estimacion
     * @param EmpresaRepository $empresa
     */
    public function __construct(EstimacionRepository $estimacion, EmpresaRepository $empresa,ContratoProyectadoRepository $contratoProyectado, RequisicionRepository $requisicion)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:consultar_formato_estimacion', ['only' => ['estimacion_pdf', 'estimacion']]);
        $this->middleware('permission:consultar_formato_comparativa_presupuestos', ['only' => ['comparativa_presupuestos']]);
        //Permisos solicitud de recursos pdf
        $this->middleware('permission:consultar_pdf_solicitud_recursos', ['only' => ['solicitud_recursos_pdf']]);

        $this->estimacion = $estimacion;
        $this->empresa = $empresa;
        $this->contratoProyectado = $contratoProyectado;
        $this->requisicion = $requisicion;
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

    public function comparativa_cotizaciones_contrato_pdf($id) {
        $contrato_proyectado = $this->contratoProyectado->find($id);
        $pdf = new ComparativaCotizacionesContrato($contrato_proyectado);
        $pdf->create()->Output('I', 'Formato - Comparativa de Cotizaciones Contratos.pdf', 1);
    }

    public function comparativa_cotizaciones_compra_pdf($id) {
        $requisicion = $this->requisicion->find($id);
        $pdf = new ComparativaCotizacionesCompra($requisicion);
        $pdf->create()->Output('I', 'Formato - Comparativa de Cotizaciones Requisciones.pdf', 1);
    }

    public function solicitud_recursos_pdf($id)
    {
        $solicitud = SolicitudRecursos::find($id);

        $pdf = new PDFSolicitudRecursos($solicitud);
        $pdf->create()->Output('I', 'Formato - Solicitud de Recursos.pdf', 1);
    }
}
