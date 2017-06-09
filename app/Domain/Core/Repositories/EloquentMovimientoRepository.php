<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\MovimientoRepository;
use Ghi\Domain\Core\Models\MovimientoPoliza;
use Mockery\Exception;

class EloquentMovimientoRepository implements MovimientoRepository
{
    function create($idPoliza, array $movimientos)
    {
        MovimientoPoliza::create([
            'id_poliza_tipo'=>$idPoliza,
            'id_cuenta_contable'=>$movimientos['id_cuenta_contable'],
            'id_tipo_movimiento'=>$movimientos['id_tipo_movimiento'],
            'registro' => auth()->user()->idusuario
        ]);
    }

    public function getByPolizaTipoId($poliza_tipo_id)
    {
        return MovimientoPoliza::where('id_poliza_tipo', '=', $poliza_tipo_id)->get();
    }
}