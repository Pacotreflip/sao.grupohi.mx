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
        $this->session = $session;
    }

    public function index() {
        return view('home');
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
}
