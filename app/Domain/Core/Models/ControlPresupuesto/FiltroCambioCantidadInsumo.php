<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Illuminate\Database\Eloquent\Model;

class FiltroCambioCantidadInsumo extends Model
{
    protected $table = 'ControlPresupuesto.filtro_cambio_cantidad_insumos';
    protected $connection = 'cadeco';
    protected $fillable = [
        'id_solicitud_cambio',
        'id_tipo_filtro'
    ];

    public function tipoFiltro() {
        return $this->hasOne(TipoFiltro::class, "id", "id_tipo_filtro");
    }
}
