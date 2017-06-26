<?php namespace Ghi\Domain\Core\Contracts;


interface PolizaHistoricoRepository
{
    /**
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function find($id);

}