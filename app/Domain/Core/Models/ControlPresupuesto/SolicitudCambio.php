<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 11:37 AM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Carbon\Carbon;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\User;

class SolicitudCambio extends BaseModel
{
    protected $table = 'ControlPresupuesto.solicitud_cambio';
    protected $connection = 'cadeco';
    protected $fillable = [
        'fecha_solicitud',
        'id_solicita',
        'id_estatus',
        'id_tipo_orden',
        'motivo',
        'numero_folio',
        'id_obra',
        'area_solicitante'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());
        static::creating(function ($model) {
            $model->id_solicita = auth()->id();
            $model->fecha_solicitud = Carbon::now()->toDateTimeString();
            $model->id_estatus = Estatus::GENERADA;
            $model->id_obra = Context::getId();
            $model->asignaFolio();

        });
    }


    protected function asignaFolio()
    {
        return $this->numero_folio = static::where('id_tipo_orden', $this->id_tipo_orden)
                ->max('numero_folio') + 1;
    }

    public function partidas()
    {
        return $this->hasMany(SolicitudCambioPartida::class, "id_solicitud_cambio", "id");
    }

    public function tipoOrden()
    {
        return $this->hasOne(TipoOrden::class, "id", "id_tipo_orden");
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }

    public function getFechaSolicitudAttribute($fecha_solicitud)
    {
        return $fecha_solicitud ? Carbon::parse($fecha_solicitud)->format('Y-m-d') : '';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRegistro()
    {
        return $this->belongsTo(User::class, 'id_solicita');
    }


    public function conceptos(){
        return $this->hasManyThrough(Concepto::class,SolicitudCambioPartida::class, 'id_solicitud_cambio', 'id_concepto', 'id_concepto');
    }

    public function conceptosTest() {
        return $this->belongsToMany(Concepto::class, 'ControlPresupuesto.solicitud_cambio_partidas', 'id_solicitud_cambio', 'id_concepto');
    }
    public function aplicaciones() {
        return $this->belongsToMany(BasePresupuesto::class, 'ControlPresupuesto.solicitud_cambio_aplicacion', 'id_solicitud_cambio', 'id_base_presupuesto')->withPivot(['aplicada', 'created_at', 'updated_at']);
    }

}