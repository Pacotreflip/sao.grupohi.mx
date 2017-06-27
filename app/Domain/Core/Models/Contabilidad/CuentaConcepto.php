<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 27/06/2017
 * Time: 01:46 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;


use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Concepto;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaConcepto extends BaseModel
{
    use SoftDeletes;
    protected $table = 'Contabilidad.cuentas_conceptos';
    protected $fillable = [
        'id_concepto',
        'cuenta',
        'registro'
    ];

    public function concepto(){
        return $this->belongsTo(Concepto::class,'id_concepto');
    }

}