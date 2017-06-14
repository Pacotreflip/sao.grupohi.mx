<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 13/06/2017
 * Time: 02:46 PM
 */

namespace Ghi\Domain\Core\Models;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function fromDateTime($value)
    {
        return substr(parent::fromDateTime($value), 0, -3);
    }
}