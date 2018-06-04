<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 01/06/2018
 * Time: 05:32 PM
 */

namespace Ghi\Api\Controllers\v1;


use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\CostoRepository;
use Ghi\Domain\Core\Transformers\CostoTreeTransformer;
use Ghi\Http\Controllers\Controller;

class CostoController extends Controller
{
    use Helpers;

    protected $costoRepository;

    /**
     * CostoController constructor.
     */
    public function __construct(CostoRepository $costoRepository)
    {
        $this->costoRepository = $costoRepository;
    }

    public function getRoot()
    {
        $roots = $this->costoRepository->getRootLevels();
        $resp = CostoTreeTransformer::transform($roots);
        return response()->json($resp, 200);
    }

    public function getNode($id)
    {
        $node = $this->costoRepository->getDescendantsOf($id);
        $resp = CostoTreeTransformer::transform($node);

        return response()->json($resp, 200);
    }
}