<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Illuminate\Database\Eloquent\Model;

class CatalogoExtraordinario extends Model
{
    protected $table = 'ControlPresupuesto.catalogo_extraordinarios';
    protected $connection = 'cadeco';
    public $incrementing = false;
    protected $fillable = [
        'descripcion',
        'creado_por'
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->creado_por = auth()->id();

        });
    }

    public function partidas()
    {
        return $this->hasMany(CatalogoExtraordinarioPartidas::class, "id_catalogo_extraordinarios", "id");
    }
}
