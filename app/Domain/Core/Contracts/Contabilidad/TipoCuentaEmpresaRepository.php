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
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|TipoCuentaEmpresa
     */
    public function find($id);

    /**
     * Obtiene todos los tipos de Cuenta en empresa
     *
     * @return \Illuminate\Database\Eloquent\Collection|TipoCuentaEmpresa
     */
    public function all();


    /**
     * Guarda un nuevo registro de TipoCuentaEmpresa
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\TipoCuentaEmpresa
     * @throws \Exception
     */
    public function create($data);

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations);

    /**
     *  Contiene los parametros de búsqueda
     * @param array $where
     * @return mixed
     */
    public function where(array $where);



}