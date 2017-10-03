<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 22/09/2017
 * Time: 11:28 AM
 */

namespace Ghi\Domain\Core\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class AlmacenTreeTransformer extends AbstractTransformer
{
    /**
     * @param Almacen $almacen
     * @return array
     */
    public function transformModel(Model $almacen)
    {
        $output = [
            'id' => $almacen->id_almacen,
            'text' => $almacen->descripcion,
            'children' => false,
            'type' => 'almacen',

        ];
        return $output;

    }

}