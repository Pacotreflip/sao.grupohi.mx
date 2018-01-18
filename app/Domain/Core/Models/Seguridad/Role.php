<?php

namespace Ghi\Domain\Core\Models\Seguridad;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $connection = "seguridad";

    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];
}