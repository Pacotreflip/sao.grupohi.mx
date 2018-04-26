<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 23/04/2018
 * Time: 01:48 PM
 */

namespace Ghi\Api\Controllers\v1\Compras;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Http\Controllers\Controller;

/**
 * Class RequisicionController
 * @package Ghi\Api\Controllers\v1\Compras
 */
class RequisicionController extends Controller
{
    use Helpers;

    /**
     * @var RequisicionRepository
     */
    private $requisicionRepository;

    /**
     * RequisicionController constructor.
     * @param RequisicionRepository $requisicionRepository
     */
    public function __construct(RequisicionRepository $requisicionRepository)
    {
        $this->requisicionRepository = $requisicionRepository;
    }

    /**
     * @return mixed
     */
    public function show(){
        return $this->response()->array($this->requisicionRepository->all(), function ($item) {
            return $item;
        });
    }
}