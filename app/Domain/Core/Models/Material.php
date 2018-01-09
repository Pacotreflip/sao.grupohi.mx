<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\CuentaMaterial;
use Ghi\Domain\Core\MOdels\Transacciones\Item;
use Ghi\Domain\Core\Models\Transacciones\Tipo;


class Material extends BaseModel
{

    const TIPO_MATERIALES            = 1;
    const TIPO_MANO_OBRA_Y_SERVICIOS = 2;
    const TIPO_HERRAMIENTA_Y_EQUIPO  = 4;
    const TIPO_MAQUINARIA            = 8;

    const NIVEL_FAMILIA = '___.';

    protected $connection = 'cadeco';
    protected $table = 'dbo.materiales';
    protected $primaryKey = 'id_material';
    protected $fillable = [
        'nivel'
        ,'tipo_material'
        ,'descripcion'
        ,'id_material'
         ,'unidad'
         ,'unidad_compra'
         ,'unidad_capacidad'
         ,'equivalencia'
         ,'marca'
         ,'id_insumo'
         ,'consumo'
         ,'codigo_externo'
         ,'merma'
         ,'secuencia'
         ,'cuenta_contable'
         ,'numero_parte'
         ,'IDMarca'
         ,'IDModelo'
         ,'FechaHoraRegistro'
        ,'UsuarioRegistro'
    ];

    public $timestamps = false;

    protected $appends = [
        'nivel_hijos',
        'nivel_padre',
        'id_padre',
        'tiene_hijos',
    ];

    public function getNivelHijosAttribute() {
        return $this->nivel . '___.';
    }

    public function scopeMateriales($query){
        return $query->where('tipo_material','=',$this::TIPO_MATERIALES);
    }

    public function items() {
        return $this->hasMany(Item::class, 'id_material');
    }

    public function scopeConTransaccionES($query) {
        return $query->whereHas('items.transaccion', function ($q){
            $q->whereIn('transacciones.tipo_transaccion', Tipo::TIPO_TRANSACCION);
        });
    }

    public function cuentaMaterial(){
        return $this->hasOne(CuentaMaterial::class, 'id_material', 'id_material');
    }

    public function scopeFamilias($query) {

        return $query->where('nivel', 'like', $this::NIVEL_FAMILIA);
    }

    public function getIdPadreAttribute() {

        if($this->nivel_padre != '') {

            $padre = false;

            $padre = Material::where('nivel', '=', $this->nivel_padre)
                ->where('tipo_material', '=', $this->tipo_material)->first();

            // El material no tiene padre
            if (is_null($padre))
                return false;

            else
                return $padre->id_material;
        }
    }

    /**
     * @return bool|string
     */
    public function getNivelPadreAttribute() {
        return substr($this->nivel, 0, strlen($this->nivel) - 4);
    }

    /**
     * @return integer
     */
    public function getTieneHijosAttribute() {
        return  Material::where('nivel', 'like', $this->nivel_hijos)
            ->where('tipo_material', '=', $this->tipo_material)
            ->count();
    }

    /**
     * @return bool
     */
    public function getCargadoAttribute() {
        return false;
    }

    public function __toString()
    {
        return $this->descripcion;
    }

}
