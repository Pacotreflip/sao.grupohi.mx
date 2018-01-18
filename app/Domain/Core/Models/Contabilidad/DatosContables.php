<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Obra;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatosContables extends BaseModel
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.datos_contables_obra';

    protected $fillable = [
        'id_obra',
        'BDContPaq',
        'NumobraContPaq',
        'FormatoCuenta',
        'FormatoCuentaRegExp',
        'manejo_almacenes',
        'costo_en_tipo_gasto',
        'retencion_antes_iva',
        'deductiva_antes_iva',
        'amortizacion_antes_iva',
    ];

    protected $appends = ['mask'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Obra
     */
    public function obra() {
        return $this->belongsTo(Obra::class, 'id_obra');
    }

    public function getMaskAttribute() {
        return str_replace('#', '0', $this->FormatoCuenta);
    }
}
