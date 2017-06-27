<?php

namespace Ghi\Http\Controllers;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Obra;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * The signed in user.
     * @var
     */
    protected $user;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->user = auth()->user();
        view()->share('user', $this->user);
        view()->share('signedIn', auth()->check());
    }

    /**
     * Obtiene el id de la obra en contexto.
     *
     * @return int
     */
    protected function getIdObra()
    {
        return Context::getId();
    }

    /**
     * Obtiene la obra en el contexto.
     *
     * @return Obra
     */
    protected function getObraEnContexto()
    {
        return Obra::findOrFail($this->getIdObra());
    }
}
