<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Illuminate\Support\Facades\DB;

class ConceptoPath extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'PresupuestoObra.conceptosPath';
    protected $primaryKey = 'id_concepto';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());
    }
    public $timestamps = false;
    protected $fillable = [
        'id_obra'
        , 'id_concepto'
        , 'nivel'
        , 'filtro1'
        , 'filtro2'
        , 'filtro3'
        , 'filtro4'
        , 'filtro5'
        , 'filtro6'
        , 'filtro7'
        , 'filtro8'
        , 'filtro9'
        , 'filtro10'
        , 'filtro11'

    ];

    public static function getColumnsAttribute() {
        $columns = [];
        try {
            $dbColumns = DB::connection('cadeco')
                ->table('INFORMATION_SCHEMA.COLUMNS')
                ->select(
                    DB::raw('[COLUMN_NAME] as name_column'),
                    DB::raw("'' as description"),
                    DB::raw("REPLACE ([COLUMN_NAME],'filtro','') as order_by")
                )
                ->where('TABLE_NAME', '=', 'conceptosPath')
                ->where('TABLE_SCHEMA', '=', 'PresupuestoObra')
                ->where('COLUMN_NAME', 'LIKE', 'filtro%')
                ->orderby('COLUMN_NAME')->get();
            $maxColumns = Concepto::getMaxNivel();
            $columns = array_slice(collect($dbColumns)->sortBy('order_by')->toArray() ,0,($maxColumns?$maxColumns[0]:env('MAX_NIVEL_COLUMNS_PRESUPUESTO')));
        }catch (\Exception $e){
            dd($e->getTraceAsString());
        }
        return $columns;
    }
}