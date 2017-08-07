<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaMaterial extends BaseModel
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.cuentas_materiales';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_material',
        'cuenta',
        'id_tipo_cuenta_material',
        'id_obra',
        'registro',
        'estatus'
    ];

    protected $appends = ['usuario_registro'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->estatus = 1;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRegistro() {
        return $this->belongsTo(User::class, 'registro');
    }

    /**
     * @return string
     */
    public function getUsuarioRegistroAttribute() {
        return (String) $this->userRegistro;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | TipoCuentaMaterial
     */
    public function tipoCuentaMaterial() {
        return $this->belongsTo(TipoCuentaMaterial::class, 'id_tipo_cuenta_material', 'id');
    }
}
