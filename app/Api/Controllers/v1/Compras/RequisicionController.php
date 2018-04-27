<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 23/04/2018
 * Time: 01:48 PM
 */

namespace Ghi\Api\Controllers\v1\Compras;

use Dingo\Api\Routing\Helpers;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

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
     * @param Request $request
     * @return mixed
     */
    public function show(Request $request){
        if(!empty($request->get('q') && is_array($request->get('columns')) && count($request->get('columns')))) {
            $result = $this->requisicionRepository->like($request->get('columns'), $request->get('q'));
            return $this->response()->array($result, function ($item) {
                return $item;
            });
        }
    }
}