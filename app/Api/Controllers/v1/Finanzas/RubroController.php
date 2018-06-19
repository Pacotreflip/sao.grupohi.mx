<?php
/**
 * Created by PhpStorm.
 * User: JFESQUIVEL
 * Date: 18/06/2018
 * Time: 19:21 PM
 */

namespace Ghi\Api\Controllers\v1\Finanzas;

use Ghi\Domain\Core\Contracts\Finanzas\RubroRepository;
use Ghi\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class RubroController extends BaseController
{
    /**
     * @var RubroRepository
     */
    protected $rubroRepository;

    /**
     * RubroController constructor.
     *
     * @param RubroRepository $rubroRepository
     */
    public function __construct(RubroRepository $rubroRepository)
    {
        $this->rubroRepository = $rubroRepository;
    }

    public function index(Request $request) {
        $rubros = $this->rubroRepository->where($request->where ? : [])->with($request->with ? : [])->all();
        return response()->json($rubros);
    }
}