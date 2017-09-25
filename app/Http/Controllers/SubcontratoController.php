<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\SubcontratoRepository;
use Illuminate\Http\Request;

class SubcontratoController extends Controller
{
    use Helpers;

    /**
     * @var SubcontratoRepository
     */
    private $subcontrato;

    public function __construct(SubcontratoRepository $subcontrato)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->subcontrato = $subcontrato;
    }

    public function getBy(Request $request) {
        $items = $this->subcontrato->getBy($request->attribute, $request->operator, $request->value);
        return response()->json(['data' => ['subcontratos' => $items]], 200);
    }
}