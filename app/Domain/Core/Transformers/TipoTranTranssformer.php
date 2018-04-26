<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 20/04/2018
 * Time: 12:50 PM
 */

namespace Ghi\Domain\Core\Transformers;


use Ghi\Domain\Core\Models\TipoTransaccion;
use League\Fractal\TransformerAbstract;

class TipoTranTranssformer extends TransformerAbstract
{
    public function transform(TipoTransaccion $tipoTransaccion) {
        return $tipoTransaccion->setHidden($tipoTransaccion->getAppends())->attributesToArray();
    }
}