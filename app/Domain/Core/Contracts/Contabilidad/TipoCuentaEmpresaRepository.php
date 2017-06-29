<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 29/06/2017
 * Time: 11:11 AM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;


use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaEmpresa;

interface TipoCuentaEmpresaRepository
{

    /**
     * Obtiene todos los tipos de Cuenta en empresa
     *
     * @return \Illuminate\Database\Eloquent\Collection|TipoCuentaEmpresa
     */
      public function  all();
}