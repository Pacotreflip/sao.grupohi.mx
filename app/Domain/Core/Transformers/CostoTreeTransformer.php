<?php
namespace Ghi\Domain\Core\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class CostoTreeTransformer extends AbstractTransformer
{
    /**
     * @param Costo $Costo
     * @return array
     */
    public function transformModel(Model $costo)
    {
        $output = [
            'id'       => $costo->id_costo,
            'nivel'    => $costo->nivel,
            'text'     => $costo->clave_Costo ? $costo->clave_Costo.' - '.$costo->descripcion : $costo->descripcion,
            'children' => $costo->tieneDescendientes(),
        ];
        return $output;

    }
}
