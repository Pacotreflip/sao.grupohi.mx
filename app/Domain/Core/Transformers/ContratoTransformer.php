<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 07/11/2017
 * Time: 11:07 AM
 */

namespace Ghi\Domain\Core\Transformers;

use Ghi\Domain\Core\Models\Contrato;
use League\Fractal\TransformerAbstract;


class ContratoTransformer extends TransformerAbstract {

    public function transform(Contrato $contrato) {
        return $contrato->attributesToArray();
    }
}