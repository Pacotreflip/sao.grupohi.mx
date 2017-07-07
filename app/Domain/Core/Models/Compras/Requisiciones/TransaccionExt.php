<?php

namespace Ghi\Domain\Core\Models\Compras\Requisiciones;

use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Illuminate\Database\Eloquent\Model;

class TransaccionExt extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cadeco';

    /**
     * @var string
     */
    protected $table = 'Compras.transacciones_ext';

    /**
     * @var string
     */
    protected $primaryKey = 'id_transaccion';

    /**
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
        'id_transaccion',
        'id_departamento',
        'id_tipo_requisicion',
        'folio_adicional'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->folio_adicional =
                DepartamentoResponsable::find($model->id_departamento)->descripcion_corta
                . '-'
                . TipoRequisicion::find($model->id_tipo_requisicion)->descripcion_corta
                . '-'
                . Requisicion::find($model->id_transaccion)->numero_folio;
        });


    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Transaccion
     */
    public function transaccion() {
        return $this->belongsTo(Transaccion::class, 'id_transaccion', 'id_transaccion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|DepartamentoResponsable
     */
    public function departamentoResponsable() {
        return $this->belongsTo(DepartamentoResponsable::class, 'id_departamento', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|TipoRequisicion
     */
    public function tipoRequisicion() {
        return $this->belongsTo(TipoRequisicion::class, 'id_tipo_requisicion', 'id');
    }
}