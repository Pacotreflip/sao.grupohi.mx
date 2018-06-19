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

    public function lists() {
        return $this->rubroRepository->lists();
    }
}