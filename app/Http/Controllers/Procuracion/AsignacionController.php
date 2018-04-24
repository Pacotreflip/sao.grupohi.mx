<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 19/04/18
 * Time: 9:38
 */

namespace Ghi\Http\Controllers\Procuracion;

use Ghi\Domain\Core\Contracts\Procuracion\AsignacionRepository;
use Ghi\Http\Controllers\Controller;

class AsignacionController extends Controller
{
    /**
     * @var AsignacionRepository
     */
    protected $asignacion;

    /**
     * AsignacionController constructor.
     * @param AsignacionRepository $asignacion
     */
    public function __construct(AsignacionRepository $asignacion)
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