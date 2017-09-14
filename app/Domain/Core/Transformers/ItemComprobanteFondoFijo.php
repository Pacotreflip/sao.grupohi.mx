<?php

namespace Ghi\Domain\Core\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class ItemComprobanteFondoFijo extends AbstractTransformer
{
    /**
     * @param Concepto $concepto
     * @return array
     */
    public function transformModel(Model $item)
    {
        $output = [
            "id_item"=>$item->id_item,
            "id_transaccion" => $item->id_transaccion,
            "id_concepto" => $item->id_concepto,
            "id_material" => $item->id_material,
            "cantidad" => $item->cantidad,
            "unidad" => $item->unidad,
            "precio_unitario" => $item->precio_unitario,
            "importe" => $item->importe,
            "destino" => $item->concepto->descripcion,
            "gastos_varios"=>$item->referencia,
            "material"=>$item->id_material?$item->material->descripcion:'',

        ];
        return $output;

    }
}
