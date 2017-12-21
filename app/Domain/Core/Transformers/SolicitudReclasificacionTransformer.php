<?php
/**
 * Created by PhpStorm.
 * User: mirah
 * Date: 20/12/2017
 * Time: 07:25 PM
 */

namespace Ghi\Domain\Core\Transformers;


use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class SolicitudReclasificacionTransformer extends AbstractTransformer
{
    protected function transformModel(Model $modelOrCollection)
    {
        return [
            '1' => '1',
            '2' => '2',
            'transaccion' =>
        ];
    }
}