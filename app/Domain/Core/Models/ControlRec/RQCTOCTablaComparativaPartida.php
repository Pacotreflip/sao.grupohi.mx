<?php

namespace Ghi\Domain\Core\Models\ControlRec;

use Illuminate\Database\Eloquent\Model;

class RQCTOCTablaComparativaPartida extends Model
{
    protected $connection = 'controlrec';

    protected $table = 'rqctoc_tabla_comparativa_partidas';
    protected $primaryKey = 'idrqctoc_tabla_comparativa_partidas';


}
