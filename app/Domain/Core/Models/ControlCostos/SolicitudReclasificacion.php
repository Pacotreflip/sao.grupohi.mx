<?php

namespace Ghi\Domain\Core\Models\ControlCostos;

use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Seguridad\Cierre;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SolicitudReclasificacion extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'ControlCostos.solicitud_reclasificacion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'motivo',
        'estatus',
        'registro',
        'fecha',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {
            $model->estatus = 1;
            $model->registro = auth()->user()->idusuario;
            $model->id_obra = Context::getId();

            // Obtenemos la fecha con la que se intenta registrar la solicitud
            $date = new Carbon($model->fecha);

            // Comprobamos si existe un cierre para el Mes y Año proporcionados
            if($cierre = Cierre::where('anio', '=', $date->year)->where('mes', '=', $date->month)->first())
            {
                //Si el cierre devuelto esta cerrado para registro
                if(! $cierre->abierto)
                {
                    $proxima_fecha = null;
                    //Agregamos un Mes a la fecha para evaluar el siguiente periodo
                    $date->day = 1;

                    //Buscamos el proximo periodo que no presente cierres o se encuentre abierto
                    for($abierto = false; $abierto != true; $date->addMonth())
                    {
                        if($cierre = Cierre::where('anio', '=', $date->year)->where('mes', '=', $date->month)->first()) {
                            if($cierre->abierto) {
                                $abierto = true;
                                $date->subMonth();
                            }
                        } else {
                            $abierto = true;
                            $date->subMonth();
                        }
                    }

                    //Buscamos el primer día hábil del periodo abierto
                    for($es_habil = false; $es_habil != true; $date->addDay()) {
                        $query = DB::connection('seguridad')
                            ->select(DB::raw("SELECT IIF('{$date}' not in (SELECT fecha FROM [SEGURIDAD_ERP].[dbo].[dias_festivos]) and DATEPART(dw, '{$date}')  not in (1,7) , 1, 0) as es_habil"));
                        $es_habil = (bool) $query[0]->es_habil;
                        if($es_habil) {
                            $proxima_fecha = $date->subDay();
                        }
                    }

                    throw new HttpResponseException(new Response('No se puede registrar la solicitud en la fecha ingresada debido a que pertenece a un periodo cerrado. La siguiente fecha disponible es: '. $proxima_fecha->toDateString(), 400, ['next-date' => $proxima_fecha->toDateString()]));
                }
            }
        });
    }

    public function partidas()
    {
        return $this->hasMany(SolicitudReclasificacionPartidas::class, 'id_solicitud_reclasificacion', 'id');
    }

    public function estatusString()
    {
        return $this->belongsTo(Estatus::class, 'estatus', 'estatus');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'registro', 'idusuario');
    }

    public function autorizacion()
    {
        return $this->hasOne(SolicitudReclasificacionAutorizada::class, 'id_solicitud_reclasificacion', 'id');
    }

    public function rechazo()
    {
        return $this->hasOne(SolicitudReclasificacionRechazada::class, 'id_solicitud_reclasificacion', 'id');
    }
}
