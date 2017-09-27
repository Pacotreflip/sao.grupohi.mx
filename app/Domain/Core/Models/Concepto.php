<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;

class Concepto extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.conceptos';
    protected $primaryKey = 'id_concepto';
    protected $appends=[
        'nivel_hijos',
        'nivel_padre',
        'id_padre',
        'tiene_hijos',
        'cargado'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cuentaConcepto()
    {
        return $this->hasOne(CuentaConcepto::class, 'id_concepto')->where('Contabilidad.cuentas_conceptos.estatus', '=', 1);
    }

    /**
     * @return string
     */
    public function getNivelHijosAttribute() {
        return $this->nivel.'___.';
    }

    /**
     * @return bool|string
     */
    public function getNivelPadreAttribute() {
        return substr($this->nivel, 0, strlen($this->nivel) - 4);
    }

    /**
     * @return integer
     */
    public function getIdPadreAttribute() {
        if($this->nivel_padre != '') {
            return Concepto::where('nivel', '=', $this->nivel_padre)->first()->id_concepto;
        }
        return null;
    }

    /**
     * @return integer
     */
    public function getTieneHijosAttribute() {
        return  Concepto::where('nivel', 'like', $this->nivel_hijos)->count();
    }

    /**
     * @return bool
     */
    public function getCargadoAttribute() {
        return false;
    }

    public function __toString()
    {
        return $this->descripcion;
    }

    public function padre() {
        return Concepto::where('nivel', '=', $this->nivel_padre)->first();
    }
}