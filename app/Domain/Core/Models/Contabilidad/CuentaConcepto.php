<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaConcepto extends BaseModel
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.cuentas_conceptos';
    protected $fillable = [
        'id_concepto',
        'cuenta',
        'registro',
        'estatus'
    ];

    public function __construct(array $attributes = [])
    {
        $attributes['estatus'] = 1;
        parent::__construct($attributes);
    }

    protected $appends = ['usuario_registro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function concepto(){
        return $this->belongsTo(Concepto::class,'id_concepto');
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