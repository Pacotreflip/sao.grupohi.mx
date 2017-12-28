<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 26/09/2017
 * Time: 11:38 AM
 */

namespace Ghi\Domain\Core\Models;


use Ghi\Domain\Core\Models\Transacciones\Item;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.contratos';
    protected $primaryKey = 'id_concepto';
    protected $fillable = [
        'id_transaccion',
        'descripcion',
        'unidad',
        'cantidad_original',
        'cantidad_presupuestada',
        'cantidad_modificada',
        'estado',
        'clave',
        'id_marca',
        'id_modelo',
        'nivel'
    ];

    public $timestamps = false;

    public function __toString()
    {
        return $this->descripcion;
    }

    public function destinos() {
        return $this->belongsToMany(Concepto::class, 'destinos', 'id_concepto_contrato', 'id_concepto')->withPivot(['id_transaccion', 'id_concepto_original']);
    }

    public function items() {
        return $this->hasMany(Item::class, 'id_concepto', 'id_concepto')
            ->where('items.id_antecedente', '=', $this->id_transaccion);
    }
}