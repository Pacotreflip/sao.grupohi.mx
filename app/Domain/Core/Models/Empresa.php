<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\CuentaEmpresa;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Illuminate\Support\Facades\DB;

class Empresa extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.empresas';
    protected $primaryKey = 'id_empresa';
    protected $appends = ['total_cuentas'];

    public function cuentasEmpresa()
    {
        return $this->hasMany(CuentaEmpresa::class, 'id_empresa')->where('Contabilidad.cuentas_empresas.estatus','=',1);
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

    public function scopeSubcontratos($query) {
        return $query
            ->select(DB::raw('DISTINCT dbo.empresas.id_empresa, dbo.empresas.razon_social'))
            ->join('dbo.transacciones', 'dbo.empresas.id_empresa', '=', 'dbo.transacciones.id_empresa')
            ->whereIn('dbo.transacciones.tipo_transaccion', [Tipo::ESTIMACION, Tipo::SUBCONTRATO])
            ->orderBy('dbo.empresas.razon_social');
    }
}