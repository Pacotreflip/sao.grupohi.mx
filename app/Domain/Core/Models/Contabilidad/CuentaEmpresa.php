<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 02:45 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;



use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
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


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {
            $model->estatus = 1;
            $model->registro = auth()->id();
            $model->id_obra = Context::getId();
        });
    }

    public function getTotalCuentasAttribute(){
        return  CuentaEmpresa::where('id_empresa', '=', $this->id_empresa)->where('estatus','=','1')->count();
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
    public function tipoCuentaEmpresa() {
        return $this->belongsTo(TipoCuentaEmpresa::class, 'id_tipo_cuenta_empresa');
    }

}