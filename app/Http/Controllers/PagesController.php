<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\NotificacionRepository;
use Ghi\Domain\Core\Contracts\GraficasRepository;
use Ghi\Domain\Core\Contracts\UserRepository;
use Illuminate\Session\Store;

class PagesController extends Controller
{

    private $session;
    /**
     * @var Notificacion
     */
    private $notificacion;

    private $grafica;

    public function __construct(Store $session,NotificacionRepository $notificacion, GraficasRepository $grafica)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context', ['only' => 'sistema_contable']);
        $this->session = $session;
        $this->notificacion=$notificacion;
        $this->grafica = $grafica;
    }

    public function index() {
        return view('pages.index');
    }

    /**
     * Lista de obras asociadas al usaurio
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

    public function welcome() {
        return view('pages.welcome');
    }

    public function sistema_contable() {
        $config = $this->grafica->getChartInfo();
        $acumulado = $this->grafica->getChartAcumuladoInfo();
        $cuentas_contables = $this->grafica->getChartCuentaContableInfo();

        return view('sistema_contable.index')
                        ->with('acumulado', $acumulado)
                        ->with('cuentas_contables', $cuentas_contables)
                        ->with('config', $config);
    }

    public function compras() {
        return view('compras.index');
    }
}
