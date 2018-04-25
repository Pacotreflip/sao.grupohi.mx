<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 19/04/18
 * Time: 12:11
 */

namespace Ghi\Domain\Core\Transformers;


use Ghi\Domain\Core\Models\Procuracion\Asignacion;
use League\Fractal\TransformerAbstract;

/**
 * Class AsignacionTransformer
 * @package Ghi\Domain\Core\Transformers
 */
class AsignacionTransformer extends TransformerAbstract
{
    /**
     * @param Asignacion $asignacion
     * @return mixed
     */
    public function transform(Asignacion $asignacion) {
        return $asignacion;
    }
}