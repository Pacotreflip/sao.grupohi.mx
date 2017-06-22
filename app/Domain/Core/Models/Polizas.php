<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\TiposPolizaContpaq;
use Ghi\Domain\Core\Models\TransaccionInterfaz;
use Ghi\Domain\Core\Models\Transacciones;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class polizas extends Model
{
    use SoftDeletes;
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.int_polizas';
    protected $primaryKey = 'id_int_poliza';
    protected $fillable = [
        'id_tipo_poliza',
        'id_tipo_poliza_interfaz',
        'id_tipo_poliza_contpaq',
        'alias_bd_cadeco',
        'id_obra_cadeco',
        'id_transaccion_sao',
        'id_obra_contpaq',
        'alias_bd_contpaq',
        'fecha',
        'concepto',
        'total',
        'cuadre',
        'timestamp_registro',
        'estatus',
        'timestamp_lanzamiento',
        'usuario_lanzamiento',
        'id_poliza_contpaq',
        'poliza_contpaq',
        'registro'
          ];

    public function transaccionInterfaz() {
        return $this->belongsTo(TransaccionInterfaz::class, 'id_tipo_poliza_interfaz');
    }
    public function transacciones() {
        return $this->belongsTo(Transacciones::class, 'id_transaccion_sao');
    }
    public function tiposPolizasContpaq() {
        return $this->belongsTo(TiposPolizaContpaq::class, 'id_tipo_poliza_contpaq');
    }

    public function polizasMovimiento() {
        return $this->hasMany(polizasMovimientos::class, 'id_int_poliza');
    }

}
