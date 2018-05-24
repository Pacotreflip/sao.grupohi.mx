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
     * @param CatalogoExtraordinario $model
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
            'precio_unitario'=>$partida->precio_unidario,
            'monto_presupuestado'=>$partida->monto_presupuestado
        ];
        $insumos = $this->model->where('nivel', 'like', '___.___.')->get();
        foreach ($insumos as $insumo){
            $extraordinario += [
                str_replace(' ', '', $insumo->descripcion) => [
                    'nivel' => $insumo->nivel,
                    'descripcion' => $insumo->descripcion,
                    'monto_presupuestado' => $insumo->monto_presupuestado,
                    'insumos' => $insumo->insumos()->get(['nivel', 'descripcion', 'unidad', 'id_material', 'cantidad_presupuestada', 'precio_unitario', 'monto_presupuestado'])->toArray()
                ]
            ];
        }

        return $extraordinario;
    }

    public function getExtraordinarioNuevo($id)
    {
        $extraordinario = [];
        $extraordinario += [
            'nivel'=>'',
            'descripcion'=>'',
            'unidad'=>'',
            'id_material'=>'',
            'cantidad_presupuestada'=>'',
            'precio_unitario'=>'',
            'monto_presupuestado'=>''
        ];
        $insumos = [
            'MATERIALES',
            'MANOOBRA',
            'HERRAMIENTAYEQUIPO',
            'MAQUINARIA',
            'SUBCONTRATOS',
            'GASTOS'
        ];
        foreach ($insumos as $insumo){
            $extraordinario += [
                str_replace(' ', '', $insumo) => [
                    'nivel' => '',
                    'descripcion' => '',
                    'monto_presupuestado' => '',
                    'insumos' => []
                ]
            ];
        }
        return $extraordinario;
    }
}