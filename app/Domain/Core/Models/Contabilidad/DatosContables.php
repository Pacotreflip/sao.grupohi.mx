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
        'BDContPaq',
        'NumobraContPaq',
        'FormatoCuenta',
        'FormatoCuentaRegExp',
        'manejo_almacenes',
        'costo_en_tipo_gasto'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Obra
     */
    public function obra() {
        return $this->belongsTo(Obra::class, 'id_obra');
    }
}
