<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Http\Response\Format\Json;
use Ghi\Domain\Core\Contracts\Contabilidad\NotificacionRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\UserRepository;
use Illuminate\Session\Store;

class PagesController extends Controller
{

    private $session;
    /**
     * @var Notificacion
     */
    private $notificacion;

    private $poliza;

    public function __construct(Store $session,NotificacionRepository $notificacion, PolizaRepository $poliza)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context', ['only' => 'sistema_contable']);
        $this->session = $session;
        $this->notificacion=$notificacion;
        $this->poliza = $poliza;
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
        $config = $this->poliza->getChartInfo();

        return view('sistema_contable.index')->with('config', $config);
    }

    public function compras() {
        return view('compras.index');
    }
}
