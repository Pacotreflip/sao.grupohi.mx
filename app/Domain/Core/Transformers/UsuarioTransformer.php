<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 20/04/2018
 * Time: 10:01 AM
 */

namespace Ghi\Domain\Core\Transformers;

use Ghi\Domain\Core\Models\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UsuarioTransformer
 * @package Ghi\Domain\Core\Transformers
 */
class UsuarioTransformer extends TransformerAbstract
{
    /**
     * @param User $usuarios
     * @return array
     */
    public function transform(User $usuarios) {
        return $usuarios->setHidden($usuarios->getAppends())->attributesToArray();
    }
}