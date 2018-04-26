<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 19/04/18
 * Time: 12:11
 */

namespace Ghi\Domain\Core\Transformers;


use Ghi\Domain\Core\Models\Procuracion\Asignaciones;
use League\Fractal\TransformerAbstract;

/**
 * Class AsignacionTransformer
 * @package Ghi\Domain\Core\Transformers
 */
class AsignacionTransformer extends TransformerAbstract
{
    /**
     * @param Asignaciones $asignacion
     * @return mixed
     */
    public function transform(Asignaciones $asignacion) {
        return $asignacion;
    }
}