<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\UserRepository;
use Illuminate\Session\Store;

class PagesController extends Controller
{

    private $session;

    public function __construct(Store $session)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context', ['only' => 'sistema_contable']);
        $this->session = $session;
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
        return view('sistema_contable.index');
    }
}
