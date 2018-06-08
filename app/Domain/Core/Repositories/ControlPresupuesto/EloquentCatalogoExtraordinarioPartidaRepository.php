<?php
/**
 * Created by PhpStorm.
 * User: 25852
 * Date: 21/05/2018
 * Time: 04:55 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\CatalogoExtraordinarioPartidaRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\CatalogoExtraordinarioPartidas;

class EloquentCatalogoExtraordinarioPartidaRepository implements CatalogoExtraordinarioPartidaRepository
{
    protected $model;

    /**
     * EloquentCatalogoExtraordinarioRepository constructor.
     * @param CatalogoExtraordinarioPartidas $model
     */
    public function __construct(CatalogoExtraordinarioPartidas $model)
    {
        $this->model = $model;
    }

    public function getPartidasByIdCatalogo($id)
    {
        $extraordinario = [];
        $partida = $this->model->where('id_catalogo_extraordinarios', '=', $id)->orderBy('nivel', 'asc')->first();
        $extraordinario += [
            'nivel'=>$partida->nivel,
            'descripcion'=>$partida->descripcion,
            'unidad'=>$partida->unidad,
            'id_material'=>$partida->id_material,
            'cantidad_presupuestada'=>$partida->cantidad_presupuestada,
            'precio_unitario'=>$partida->precio_unitario,
            'monto_presupuestado'=>$partida->monto_presupuestado
        ];
        $agrupadores = $this->model->where('nivel', 'like', '___.___.')->get();
        foreach ($agrupadores as $agrupador){
            $insumos = $agrupador->insumos()->get(['nivel', 'descripcion', 'unidad', 'id_material', 'cantidad_presupuestada', 'precio_unitario', 'monto_presupuestado'])->toArray();

            //// refactorización de montos para eliminar notación científica en rendimientos
            foreach ($insumos as $key => $insumo){
                $insumos[$key]['cantidad_presupuestada'] = floatval($insumo['cantidad_presupuestada']);
            }
            $extraordinario += [
                str_replace(' ', '', $agrupador->descripcion) => [
                    'nivel' => $agrupador->nivel,
                    'descripcion' => $agrupador->descripcion,
                    'monto_presupuestado' => $agrupador->monto_presupuestado,
                    'insumos' => $insumos
                ]
            ];
        }

        return $extraordinario;
    }

    public function getExtraordinarioNuevo()
    {
        $extraordinario = [];
        $extraordinario += [
            'nivel'=>'001.',
            'descripcion'=>'',
            'unidad'=>'',
            'id_material'=>'',
            'cantidad_presupuestada'=>0,
            'precio_unitario'=>1,
            'monto_presupuestado'=>0
        ];
        $insumos = [
            'MATERIALES',
            'MANOOBRA',
            'HERRAMIENTAYEQUIPO',
            'MAQUINARIA',
            'SUBCONTRATOS',
            'GASTOS'
        ];
        foreach ($insumos as $key => $insumo){
            $extraordinario += [
                str_replace(' ', '', $insumo) => [
                    'nivel' => '001.00'.($key+1),
                    'descripcion' => $insumo,
                    'monto_presupuestado' => 0,
                    'insumos' => []
                ]
            ];
        }
        return $extraordinario;
    }
}