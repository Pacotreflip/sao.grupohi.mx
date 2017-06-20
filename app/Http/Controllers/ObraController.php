<?php namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ObraRepository;

use Ghi\Domain\Core\Models\Obra;
use Illuminate\Http\Request;

class ObraController extends Controller
{
    use Helpers;
    /**
     * @var Obra
     */
    private $obra;

    /**
     * ObraController constructor.
     * @param ObraRepository $obra
     */
    public function __construct(ObraRepository $obra)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->obra = $obra;
    }

    public function update(Request $request) {
        $item = $this->obra->update($request);

        return response()->json(['data' => ['obra' => $item]], 200);
    }
}