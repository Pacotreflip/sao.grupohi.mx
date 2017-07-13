<?php

namespace Ghi\Domain\Core\Models\Seguridad;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $connection = "seguridad";
}