<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 29/05/2018
 * Time: 04:27 PM
 */

namespace Ghi\Api\Controllers\v1;

use Dingo\Api\Routing\Helpers;
use Ghi\Http\Controllers\Controller as BaseController;
use Ghi\Domain\Core\Contracts\FondoRepository;
use Dingo\Api\Http\Request;
use JWTAuth;

/**
 * Class FondoController
 * @package Ghi\Api\Controllers\v1
 */
class FondoController extends BaseController
{

    use Helpers;
    /**
     * @var FondoRepository
     */
    protected $fondoRepository;

    /**
     * FondoController constructor.
     *
     * @param FondoRepository $fondoRepository
     */
    public function __construct(FondoRepository $fondoRepository)
    {
        $this->fondoRepository = $fondoRepository;
    }

    /**
     * @return mixed
     */
    public function lists()
    {
        $fondos = $this->fondoRepository->lists();
        return response()->json($fondos, 200);
    }

    public function find($id) {
        $fondo = $this->fondoRepository->find($id);
        return response()->json($fondo, '200');
    }
}