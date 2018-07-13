<?php
/**
 * Created by PhpStorm.
 * User: 25852
 * Date: 21/05/2018
 * Time: 04:55 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\CatalogoExtraordinarioPartidaRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\CatalogoExtraordinario;
use Ghi\Domain\Core\Models\ControlPresupuesto\CatalogoExtraordinarioPartidas;
use Illuminate\Support\Facades\DB;

class EloquentCatalogoExtraordinarioPartidaRepository implements CatalogoExtraordinarioPartidaRepository
{
    protected $model;

    protected $insumos = [
        'MATERIALES',
        'MANOOBRA',
        'HERRAMIENTAYEQUIPO',
        'MAQUINARIA',
        'SUBCONTRATOS',
        'GASTOS'
    ];

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
        $agrupadores = $this->model->where('nivel', 'like', '___.___.')->where('id_catalogo_extraordinarios', '=', $id)->get();
        foreach ($agrupadores as $key =>$agrupador){
            $insumos = $agrupador->where('nivel', 'like', $agrupador->nivel.'___.')
                ->where('id_catalogo_extraordinarios', '=', $id)
                ->get(['nivel', 'descripcion', 'unidad', 'id_material', 'cantidad_presupuestada', 'precio_unitario', 'monto_presupuestado'])
                ->toArray();

            //// refactorización de montos para eliminar notación científica en rendimientos
            foreach ($insumos as $key => $insumo){
                $insumos[$key]['cantidad_presupuestada'] = number_format(floatval($insumo['cantidad_presupuestada']), 3, '.', '');
                $insumos[$key]['precio_unitario'] = number_format(floatval($insumo['precio_unitario']), 3, '.', '');
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

        foreach ($this->insumos as $key => $insumo){
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


    public function guardarExtraordinario(array $array)
    {
        try{
            DB::connection('cadeco')->beginTransaction();

            $tipo_costo = $array['id_origen_extraordinario'] == 3 && $array['id_opcion'] == 2?2:1;
            $registro_extraordinario = CatalogoExtraordinario::create(['descripcion' => $array['motivo'], 'tipo_costo' => $tipo_costo]);

            $extraordinario = $array['extraordinario'];

            $data_concepto = [
                'id_catalogo_extraordinarios' => $registro_extraordinario->id,
                'nivel' => '001.',
                'descripcion' => $extraordinario['descripcion'],
                'unidad' => $extraordinario['unidad'],
                'cantidad_presupuestada' => $extraordinario['cantidad_presupuestada'],
                'precio_unitario' => $extraordinario['precio_unitario'],
                'monto_presupuestado' => $extraordinario['monto_presupuestado']
            ];
             $this->model->create($data_concepto);
             foreach ($this->insumos as $key_agrupador => $insumo) {
                 $agrupador = $extraordinario[$insumo];
                 $data_agrupador = [
                     'id_catalogo_extraordinarios' => $registro_extraordinario->id,
                     'nivel' => '001.'. str_pad($key_agrupador + 1, 3, "0", STR_PAD_LEFT) . '.',
                     'descripcion' => $agrupador['descripcion'],
                     'monto_presupuestado' => $agrupador['monto_presupuestado']

                 ];
                 $this->model->create($data_agrupador);

                 if(isset($agrupador['insumos'])) {
                     foreach ($agrupador['insumos'] as $key => $insumo_agrupado) {
                         $data_insumo = [
                             'id_catalogo_extraordinarios' => $registro_extraordinario->id,
                             'nivel' => '001.' . str_pad($key_agrupador + 1, 3, "0", STR_PAD_LEFT) . '.' . str_pad($key + 1, 3, "0", STR_PAD_LEFT) . '.',
                             'descripcion' => $insumo_agrupado['descripcion'],
                             'unidad' => $insumo_agrupado['unidad'],
                             'id_material' => $insumo_agrupado['id_material'],
                             'cantidad_presupuestada' => $insumo_agrupado['cantidad_presupuestada'],
                             'precio_unitario' => $insumo_agrupado['precio_unitario'],
                             'monto_presupuestado' => $insumo_agrupado['monto_presupuestado']
                         ];
                         $this->model->create($data_insumo);
                     }
                 }
             }

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}