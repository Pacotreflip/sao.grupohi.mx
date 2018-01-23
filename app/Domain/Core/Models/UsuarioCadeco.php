<?php

namespace Ghi\Domain\Core\Models;

use Illuminate\Support\Facades\Config;

class UsuarioCadeco extends \Ghi\Core\Models\UsuarioCadeco
{
    public $incrementing = false;

    public function user() {
        return $this->belongsTo(User::class, 'usuario', 'usuario');
    }
}