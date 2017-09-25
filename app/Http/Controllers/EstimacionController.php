<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\EstimacionRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class EstimacionController extends Controller
{
    use Helpers;

    /**
     * @var EstimacionRepository
     */
    private $estimacion;

    public function __construct(EstimacionRepository $estimacion)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->estimacion = $estimacion;
    }

    public function getBy(Request $request) {
        $items = $this->estimacion->getBy($request->attribute, $request->operator, $request->value);
        return response()->json(['data' => ['estimaciones' => $items]], 200);
    }
}