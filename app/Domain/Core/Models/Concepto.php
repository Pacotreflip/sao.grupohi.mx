<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 27/06/2017
 * Time: 01:49 PM
 */

namespace Ghi\Domain\Core\Models;


use Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto;
use Illuminate\Support\Facades\DB;

class Concepto extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.conceptos';
    protected $primaryKey = 'id_concepto';
    protected $appends=['nivel_hijos', 'nivel_padre', 'id_padre','tiene_hijos', 'cargado'];

    public function cuentaConcepto()
    {
        return $this->hasOne(CuentaConcepto::class, 'id_concepto')->where('Contabilidad.cuentas_conceptos.estatus', '=', 1);
    }

    public function getNivelHijosAttribute() {
        return $this->nivel.'___.';
    }

    public function getNivelPadreAttribute() {
        return substr($this->nivel, 0, strlen($this->nivel) - 4);
    }

    public function getIdPadreAttribute() {
        if($this->nivel_padre != '') {
            return Concepto::where('nivel', '=', $this->nivel_padre)->first()->id_concepto;
        }
        return null;
    }

    public function getTieneHijosAttribute() {
        return  Concepto::where('nivel', 'like', $this->nivel_hijos)->count();
    }

    public function getCargadoAttribute() {
        return false;
    }
}