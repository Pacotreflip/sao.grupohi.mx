<?php

namespace Ghi\Domain\Core\Transformers;
use Ghi\Domain\Core\Models\Sucursal;
use League\Fractal\TransformerAbstract;

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 04/11/2017
 * Time: 04:19 PM
 */

class SucursalTransformer extends TransformerAbstract {

    public function transform(Sucursal $sucursal) {
        return $sucursal->toArray();
    }
}