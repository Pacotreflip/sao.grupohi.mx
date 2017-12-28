<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 07/11/2017
 * Time: 11:07 AM
 */

namespace Ghi\Domain\Core\Transformers;

use Ghi\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Contrato;
use League\Fractal\TransformerAbstract;


class ContratoTransformer extends TransformerAbstract {

    public function transform(Contrato $contrato) {

        $destinos = [];

        foreach ($contrato->destinos as $destino) {
            $destinos []  = [
                'id_concepto' => $destino->id_concepto
            ];
        }
        return [
            'id_concepto' => $contrato->id_concepto,
            'id_transaccion' => $contrato->id_transaccion,
            'descripcion' => $contrato->descripcion,
            'nivel' => $contrato->nivel,
            'unidad' => $contrato->unidad,
            'cantidad_original' => $contrato->cantidad_original,
            'cantidad_presupuestada' => $contrato->cantidad_presupuestada,
            'destinos' => $destinos
        ];
    }
}