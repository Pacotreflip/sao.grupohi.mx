<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/06/2018
 * Time: 01:13 PM
 */

namespace Ghi\Domain\Core\Models\Finanzas;


use Carbon\Carbon;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SolicitudRecursos
 * @package Ghi\Domain\Core\Models\Finanzas
 */
class SolicitudRecursos extends Model
{

    use SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'cadeco';
    /**
     * @var string
     */
    protected $table = 'Finanzas.solicitudes_recursos';

    /**
     * @var array
     */
    protected $fillable = [
        'id_tipo',
    ];

    protected $appends = [
        'dia_inicio',
        'dia_fin',
        'estatus',
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_tipo = (new SolicitudRecursos)->getTipo()->id;
            $model->registro = auth()->id();
            $model->semana = Carbon::now()->weekOfYear;
            $model->anio = Carbon::now()->year;
            $model->folio = '';
            $model->consecutivo = $model->tipo->descripcion_corta == 'UR' ? $model->getConsecutivo() : null;
            $model->folio = $model->tipo->descripcion_corta . '-' . $model->semana . '-' . $model->anio . ($model->consecutivo ? '-' . $model->consecutivo : '');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo() {
        return $this->belongsTo(CTGTipoSolicitud::class, 'id_tipo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partidas() {
        return $this->hasMany(SolicitudRecursosPartida::class, 'id_solicitud_recursos');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario() {
        return $this->belongsTo(User::class, 'registro');
    }

    public function solicitudesUrgentes() {
        return $this->hasMany(self::class, 'semana', 'semana')->where('anio', '=', $this->anio)->whereNotNull('consecutivo');
    }

    public static function getTipo()
    {
        $hoy = Carbon::now();

        if (self::where('semana', '=', $hoy->weekOfYear)->where('anio', '=', $hoy->year)->first())
            return CTGTipoSolicitud::where('descripcion_corta', '=', 'UR')->first();
        else
            return CTGTipoSolicitud::where('descripcion_corta', '=', 'PR')->first();
    }

    public function getConsecutivo()
    {
        return $this->solicitudesUrgentes()->count() + 1;
    }

    public function scopeAbiertas($query) {
        return $query->where('estado', '=', 1);
    }

    public function getDiaInicioAttribute() {
        $date = new Carbon();
        $date->setISODate($this->anio, $this->semana);
        return $date->startOfWeek();
    }

    public function getDiaFinAttribute() {
        $date = new Carbon();
        $date->setISODate($this->anio, $this->semana);
        return $date->endOfWeek();
    }

    public function getEstatusAttribute() {
        switch ($this->estado) {
            case 1:
                return 'SOLICITADA';
                break;
            case 2:
                return 'FINALIZADA';
                break;
        }
    }
}
