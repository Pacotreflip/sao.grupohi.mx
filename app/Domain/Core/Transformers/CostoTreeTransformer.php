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
    public function transformModel(Model $Costo)
    {
        $output = [
            'id'       => $Costo->id_Costo,
            'nivel'    => $Costo->nivel,
            'text'     => $Costo->clave_Costo ? $Costo->clave_Costo.' - '.$Costo->descripcion : $Costo->descripcion,
            'children' => $Costo->tieneDescendientes(),
        ];
        return $output;

    }
}
