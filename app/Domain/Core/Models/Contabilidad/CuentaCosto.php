<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Costo;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaCosto extends BaseModel
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.cuentas_costos';
    protected $primaryKey = 'id_cuenta_costo';
    protected $fillable = [
        'id_costo',
        'cuenta',
        'registro',
        'estatus'
    ];
    protected $appends = ['usuario_registro'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->estatus = 1;
            $model->registro = auth()->user()->idusuario;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function costo(){
        return $this->belongsTo(Costo::class,'id_costo');
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
}