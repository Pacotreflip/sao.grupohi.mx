<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 01/12/2017
 * Time: 01:54 PM
 */

namespace Ghi\Domain\Core\Contracts;

use Dingo\Api\Http\Request;

interface ConciliacionRepository
{
    public function store(Request $request);
}