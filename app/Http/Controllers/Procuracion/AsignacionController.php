<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 19/04/18
 * Time: 9:38
 */

namespace Ghi\Http\Controllers\Procuracion;

use Ghi\Domain\Core\Contracts\Procuracion\AsignacionesRepository;
use Ghi\Http\Controllers\Controller;

class AsignacionController extends Controller
{
    /**
     * @var AsignacionesRepository
     */
    protected $asignacion;

    /**
     * AsignacionController constructor.
     * @param AsignacionesRepository $asignacion
     */
    public function __construct(AsignacionesRepository $asignacion)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->asignacion = $asignacion;
    }

    /**
     * @return View
     */
    public function index() {
        return view('procuracion.asignacion.index');
    }

    public function create()
    {
        return view('procuracion.asignacion.create');
    }
}