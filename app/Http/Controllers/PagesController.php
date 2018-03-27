<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\NotificacionRepository;
use Ghi\Domain\Core\Contracts\GraficasRepository;
use Ghi\Domain\Core\Contracts\UserRepository;
use Illuminate\Session\Store;

class PagesController extends Controller
{
    /**
     * @var Store
     */
    private $session;

    /**
     * @var NotificacionRepository
     */
    private $notificacion;

    /**
     * @var GraficasRepository
     */
    private $grafica;

    /**
     * PagesController constructor.
     * @param Store $session
     * @param NotificacionRepository $notificacion
     * @param GraficasRepository $grafica
     */
    public function __construct(Store $session, NotificacionRepository $notificacion, GraficasRepository $grafica)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context', ['only' => ['index', 'sistema_contable', 'formatos', 'finanzas', 'tesoreria', 'control_costos', 'control_presupuesto', 'seguridad']]);
        $this->middleware('permission:administrar_roles_permisos', ['only' => ['seguridad']]);
        //TODO: $this->middleware('permission:administrar_presupuesto', ['only' => ['presupuesto']]);
        $this->session = $session;
        $this->notificacion = $notificacion;
        $this->grafica = $grafica;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('pages.index');
    }

    /**
     * Lista de obras asociadas al usuario
     * @param UserRepository $repository
     * @return \Illuminate\View\View
     */
    public function obras(UserRepository $repository)
    {
        $this->session->put('database_name', null);
        $this->session->put('id', null);
        $obras = $repository->getObras(auth()->id());
        $obras->setPath('obras');
        return view('pages.obras')->withObras($obras);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome() {
        return view('pages.welcome');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sistema_contable() {
        $config = $this->grafica->getChartInfo();
        $acumulado = $this->grafica->getChartAcumuladoInfo();
        $cuentas_contables = $this->grafica->getChartCuentaContableInfo();

        return view('sistema_contable.index')
                        ->with('acumulado', $acumulado)
                        ->with('cuentas_contables', $cuentas_contables)
                        ->with('config', $config);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function compras() {
        return view('compras.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finanzas() {
        return view('finanzas.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function formatos() {
        return view('formatos.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tesoreria() {
        return view('tesoreria.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function control_costos() {
        return view('control_costos.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function control_presupuesto() {
        return view('control_presupuesto.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function seguridad() {
        return view('configuracion.seguridad.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function presupuesto() {
        return view('configuracion.presupuesto.index');
    }

    public function obra() {
        return view('configuracion.obra.index');
    }
}
