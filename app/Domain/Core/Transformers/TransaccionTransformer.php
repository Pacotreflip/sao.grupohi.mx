<?php

namespace Ghi\Domain\Core\Transformers;
use Ghi\Domain\Core\Models\Sucursal;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use League\Fractal\TransformerAbstract;

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 04/11/2017
 * Time: 04:19 PM
 */

class TransaccionTransformer extends TransformerAbstract {

    public function transform(Transaccion $transaccion) {
        return $transaccion->setHidden($transaccion->getAppends())->attributesToArray();
    }
}