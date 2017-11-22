<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\CuentaCosto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Illuminate\Support\Facades\DB;

class Costo extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.costos';
    protected $primaryKey = 'id_costo';
    public $timestamps = false;
    protected $fillable = [
        'id_obra',
        'nivel',
        'descripcion',
        'monto_presupuestado',
        'ajuste_presupuesto',
        'honorarios',
        'subtotal',
        'otros',
        'observaciones',
    ];
    protected $appends = [
        'nivel_hijos',
        'nivel_padre',
        'id_padre',
        'tiene_hijos',
        'cargado',
        'path'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cuentaCosto()
    {
        return $this->hasOne(CuentaCosto::class, 'id_costo')->where('Contabilidad.cuentas_costos.estatus', '=', 1);
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
            return Costo::where('nivel', '=', $this->nivel_padre)->first()->id_costo;
        }
        return null;
    }

    /**
     * @return integer
     */
    public function getTieneHijosAttribute() {
        return  Costo::where('nivel', 'like', $this->nivel_hijos)->count();
    }

    public function getPathAttribute()
    {
         if($this->nivel_padre == '') {
             return $this->descripcion;
         } else {
             $padre = Costo::find($this->id_padre);
             return $padre->path . ' -> ' . $this->descripcion;
         }
    }

    /**
     * Indica si este concepto tiene descendientes
     *
     * @return bool
     */
    public function tieneDescendientes()
    {
        return static::where('id_obra', $this->id_obra)
            ->where('nivel', '<>', $this->nivel)
            ->whereRaw("LEFT(nivel, LEN('{$this->nivel}')) = '{$this->nivel}'")
            ->exists();
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
        return Costo::where('nivel', '=', $this->nivel_padre)->first();
    }
}