<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 02:45 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;



use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Empresa;
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
      ,'estatus'
    ];

    public function __construct(array $attributes = [])
    {
        $attributes['estatus'] = 1;
        parent::__construct($attributes);
    }
    public function getTotalCuentasAttribute(){
        return  CuentaEmpresa::where('id_empresa', '=', $this->id_empresa)->count();
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
    public function tipoCuentaEmpresa() {
        return $this->belongsTo(TipoCuentaEmpresa::class, 'id_tipo_cuenta_empresa');
    }

}