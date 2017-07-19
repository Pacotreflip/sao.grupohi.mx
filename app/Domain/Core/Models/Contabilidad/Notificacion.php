<?php
namespace Ghi\Domain\Core\Models\Contabilidad;


use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Obra;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    const REMITENTE_COMPRAS = "SAO WEB";
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.notificaciones';
    protected $fillable =
        [
            'titulo',
            'contenido',
            'id_usuario',
            'id_obra',
            'remitente'
        ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ObraScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function obra() {
        return $this->belongsTo(Obra::class, 'id_obra');
    }
    /**
     * @return User
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'idusuario');
    }

    public function scopeRecientes($query){
        return $query->where('leida','=','false')->orderBy('created_at','desc')->limit(5);
    }

    public function notificaionesPoliza(){
        return $this->belongsTo(NotificacionPoliza::class, 'id_notificacion', 'id');

    }


}