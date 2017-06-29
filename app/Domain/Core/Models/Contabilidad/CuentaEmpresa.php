<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 02:45 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;


use Ghi\Domain\Core\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaEmpresa extends BaseModel
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.cuentas_empresas';
    protected $fillable = [
        'id_obra'
      ,'id_empresa'
      ,'id_tipo_cuenta_empresa'
      ,'cuenta'
      ,'registro'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|TipoCuentaContable
     */
    public function tipoCuentaContable() {
        return $this->belongsTo(TipoCuentaContable::class, 'id_int_tipo_cuenta_contable');
    }

}