<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 31/07/2017
 * Time: 04:02 PM
 */

namespace Ghi\Domain\Core\Models\Seguridad;



class DiaFestivo extends BaseModel
{
    protected $connection = 'seguridad';
    protected $table = 'dbo.dias_festivos';
}