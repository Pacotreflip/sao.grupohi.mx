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
    protected $appends=['nivel_hijos', 'nivel_padre'];

    public function cuentaConcepto()
    {
        return $this->hasOne(CuentaConcepto::class, 'id_concepto');
    }

    public function getNivelHijosAttribute() {
        return $this->nivel.'___.';
    }

    public function getNivelPadreAttribute() {
        return substr($this->nivel, 0, strlen($this->nivel) - 4);
    }
}