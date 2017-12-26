<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 14/11/2017
 * Time: 04:21 PM
 */

namespace Ghi\Domain\Core\Transformers;


use Ghi\Domain\Core\Models\Transacciones\Item;
use League\Fractal\TransformerAbstract;

class ItemTransformer extends TransformerAbstract
{
    public function transform(Item $item) {
        return $item->attributesToArray();
    }
}