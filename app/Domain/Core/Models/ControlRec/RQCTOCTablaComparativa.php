<?php

namespace Ghi\Domain\Core\Models\ControlRec;

use Illuminate\Database\Eloquent\Model;

class RQCTOCTablaComparativa extends Model
{
    protected $connection = 'controlrec';

    protected $table = 'rqctoc_tabla_comparativa';
    protected $primaryKey = 'idrqctoc_tabla_comparativa';
}
