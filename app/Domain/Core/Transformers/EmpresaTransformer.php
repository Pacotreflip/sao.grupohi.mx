<?php

namespace Ghi\Domain\Core\Transformers;
use Ghi\Domain\Core\Models\Empresa;
use League\Fractal\TransformerAbstract;

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 01/11/2017
 * Time: 04:19 PM
 */

class EmpresaTransformer extends TransformerAbstract {

    public function transform(Empresa $empresa) {

        return [
            "id_empresa" => $empresa->id_empresa,
            "tipo_empresa" => $empresa->tipo_empresa,
            "razon_social" => $empresa->razon_social,
            "rfc" => $empresa->rfc
        ];
    }
}