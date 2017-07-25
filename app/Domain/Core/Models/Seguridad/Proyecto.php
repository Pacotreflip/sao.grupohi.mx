<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 24/07/2017
 * Time: 05:14 PM
 */

namespace Ghi\Domain\Core\Models\Seguridad;


use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $connection = 'seguridad';
    protected $table = 'dbo.proyectos';
}