<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 02:48 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;


use Ghi\Domain\Core\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCuentaEmpresa extends BaseModel
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.tipos_cuentas_empresas';
    protected $fillable = [
        'descripcion',
        'id_tipo_cuenta_contable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|TipoCuentaContable
     */
    public function tipoCuentaContable()
    {
        return $this->belongsTo(TipoCuentaContable::class, 'id_int_tipo_cuenta_contable');
    }

    public function __toString()
    {
        return $this->descripcion;
    }

}