<?php

namespace Ghi\Domain\Core\Models\ControlRec;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Scopes\DatabaseScope;
use Illuminate\Database\Eloquent\Model;

class RQCTOCSolicitud extends Model
{
    protected $connection = 'controlrec';

    protected $table = 'rqctoc_solicitudes';
    protected $primaryKey = 'idrqctoc_solicitudes';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DatabaseScope());
    }

    public function rqctocSolicitudPartidas() {
        return $this->hasMany(RQCTOCSolicitudPartidas::class, 'idrqctoc_solicitudes', 'idrqctoc_solicitudes');
    }

    public function rqctocTablasComparativas() {
        return $this->hasMany(RQCTOCTablaComparativa::class, 'idrqctoc_solicitudes', 'idrqctoc_solicitudes');
    }

    public function rqctocCotizaciones() {
        return $this->hasMany(RQCTOCCotizaciones::class, 'idrqctoc_solicitudes', 'idrqctoc_solicitudes');
    }
}
