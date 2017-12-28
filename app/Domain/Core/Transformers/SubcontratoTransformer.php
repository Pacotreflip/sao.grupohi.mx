<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 14/11/2017
 * Time: 03:40 PM
 */

namespace Ghi\Domain\Core\Transformers;

use Ghi\Domain\Core\Models\Transacciones\Subcontrato;
use League\Fractal\TransformerAbstract;

class SubcontratoTransformer extends TransformerAbstract
{
    public function transform(Subcontrato $subcontrato) {
        return $subcontrato->setHidden($subcontrato->getAppends())->attributesToArray();
    }
}