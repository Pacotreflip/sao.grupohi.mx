<?php namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface PolizaHistoricoRepository
{
    /**
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function find($id);

}