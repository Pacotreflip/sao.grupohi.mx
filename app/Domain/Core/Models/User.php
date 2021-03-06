<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Core\Facades\Context;
use Ghi\Core\Presenters\UserPresenter;
use Ghi\Domain\Core\Models\Contabilidad\Notificacion;
use Ghi\Domain\Core\Models\Seguridad\Permission;
use Ghi\Domain\Core\Models\Seguridad\Proyecto;
use Ghi\Domain\Core\Models\Seguridad\Role;
use Ghi\Domain\Core\Models\Seguridad\Sistema;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Ghi\Core\App\Auth\AuthenticatableIntranetUser;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Config;
use \Entrust;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use AuthenticatableIntranetUser, CanResetPassword, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuario';

    /**
     * @var string
     */
    protected $primaryKey = 'idusuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['usuario', 'nombre', 'correo', 'clave'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['clave', 'remember_token'];

    /**
     * Consider updated_at and created_at timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Presentador de usuario
     *
     * @var
     */
    protected $presenter = UserPresenter::class;

    /**
     * Usuario cadeco relacionado con este usuario de intranet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usuarioCadeco()
    {
        return $this->hasOne(UsuarioCadeco::class, 'usuario', 'usuario');
    }

    /**
     * Hashea la clave al ser establecida
     *
     * @param string $value
     */
    public function setClaveAttribute($value)
    {
        $this->attributes['clave'] = md5($value);
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        // TODO: Implement getAuthIdentifierName() method.
    }

    public function __toString()
    {
        return $this->nombre . ' ' . $this->apaterno . ' ' . $this->amaterno;
    }

    public function notificaciones() {
        return $this->hasMany(Notificacion::class, 'id_usuario', 'idusuario');
    }

    public function notificacionesNoLeidas() {
        return $this->hasMany(Notificacion::class, 'id_usuario', 'idusuario')->where('Contabilidad.notificaciones.leida', '=', false);
    }

    public function roles()
    {
        return $this->belongsToMany(Config::get('entrust.role'), Config::get('entrust.role_user_table'), 'user_id', 'role_id')
            ->where('id_obra', Context::getId())
            ->where('id_proyecto', Proyecto::where('base_datos', '=',Context::getDatabaseName())->first()->id);
    }

    public function canAccessSystem($sistema) {
        $permisos = Sistema::where('url', '=', $sistema)->first()->permisos()->lists('name')->toArray();
        return Entrust::can($permisos);
    }

    public function getUsuarioAttribute($usuario) {
        return strtoupper($usuario);
    }

    public function transaccionesAsignadas() {
        return $this->belongsToMany(Transaccion::class, 'Procuracion.asignaciones', 'id_usuario_asignado', 'id_transaccion')->withTimestamps();
    }
}
