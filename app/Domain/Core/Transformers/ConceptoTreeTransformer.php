<?php
namespace Ghi\Domain\Core\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class ConceptoTreeTransformer extends AbstractTransformer
{
    /**
     * @param Concepto $concepto
     * @return array
     */
    public function transformModel(Model $concepto)
    {
        $output = [
            'id'       => $concepto->id_concepto,
            'nivel'    => $concepto->nivel,
            'text'     => $concepto->clave_concepto ? $concepto->clave_concepto.' - '.$concepto->descripcion : $concepto->descripcion,
            'children' => $concepto->tieneDescendientes(),
            'type'     => $concepto->activo==1?$concepto->esMaterial()&&$concepto->activo==1?'material': ($concepto->tieneDescendientes() ? 'concepto' : 'medible'):'inactivo',

        ];
        return $output;

    }
}
