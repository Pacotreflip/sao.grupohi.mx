<?php

namespace Ghi\Domain\ModulosSAO\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 19/09/2017
 * Time: 11:23 AM
 */

class Logotipo extends Model
{
    protected $connection = 'generales';

    /**
     * @var string
     */
    protected $table = 'Proyectos.Logotipos';

    /**
     * @var string
     */
    protected $primaryKey = 'IDLogotipo';
}