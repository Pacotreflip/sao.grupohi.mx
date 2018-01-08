<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Illuminate\Support\Facades\DB;

class Concepto extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.conceptos';
    protected $primaryKey = 'id_concepto';
    protected $appends = [
        'nivel_hijos',
        'nivel_padre',
        'id_padre',
        'tiene_hijos',
        'cargado',
        'path',
        'clave',
        'niveles',
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

    public function getPathAttribute()
    {
         if($this->nivel_padre == '') {
             return $this->descripcion;
         } else {
             return Concepto::find($this->id_padre)->path . ' -> ' . $this->descripcion;
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
     * Indica si este concepto es un material
     *
     * @return bool
     */
    public function esMaterial()
    {
        if ($this->id_material) {
            return true;
        }
        return false;
    }

    /**
     * Indica si el concepto es medible
     *
     * @return bool
     */
    public function esMedible()
    {
        if ($this->concepto_medible == 3 || $this->concepto_medible == 1) {
            return true;
        }
        return false;
    }

    public function __toString()
    {
        return $this->descripcion;
    }

    public function padre() {
        return Concepto::where('nivel', '=', $this->nivel_padre)->first();
    }

    public function conceptoPath() {
        return $this->hasOne(ConceptoPath::class, 'id_concepto');
    }

    public function getClaveAttribute()
    {
        if ($this->clave_concepto != null)
            return $this->clave_concepto;

        if ($this->id_padre == '')
            return '';

        // Revisa si el padre contiene clave_concepto
        $padre = $this->padre();

        if ($padre->clave_concepto)
            return $padre->clave_concepto;


        $nivel_padre = $padre->nivel_padre;
        $clave = '';

        for ($i = 1; $i <= $this->niveles; $i++) {
            $padre = Concepto::where('nivel', '=', $nivel_padre)->first();
            $nivel_padre = $padre->nivel_padre;

            if ($padre->clave_concepto)
            {
                $clave = $padre->clave_concepto;
                break;
            }
        }

        return $clave;
    }

    public function getNivelesAttribute()
    {
        preg_match_all('/(\d{3}\.)/', $this->nivel, $matches);

        return count($matches[0]);
    }
}