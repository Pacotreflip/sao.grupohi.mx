<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 06:20 PM
 */

namespace Ghi\Domain\Core\Models;


use Ghi\Domain\Core\Models\Contabilidad\CuentaEmpresa;

class Empresa extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.empresas';
    protected $primaryKey = 'id_empresa';
    protected $appends = ['total_cuentas'];
    public function __toString()
    {
        return $this->razon_social;
    }

    public function cuentasEmpresa()
    {
        return $this->hasMany(CuentaEmpresa::class, 'id_empresa');
    }

    public function getTotalCuentasAttribute()
    {
        $result = 0;
        foreach ($this->cuentasEmpresa as $cuenta) {
            $result = $result + 1;
        }
        return $result;
    }

    /**
     * @return User
     */
    public function user_registro()
    {
        return $this->belongsTo(User::class, 'UsuarioRegistro', 'idusuario');
    }

}