<?php

namespace Ghi\Domain\Core\Models\ControlRec;


use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model {

    protected $connection = 'controlrec';
    protected $table = 'proveedores';
    protected $primaryKey = 'IdProveedor';
}