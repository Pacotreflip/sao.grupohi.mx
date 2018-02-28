<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 23/02/2018
 * Time: 04:55 PM
 */

namespace Ghi\Domain\Core\Models\Seguridad;


use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
    protected $table = 'dbo.sistemas';
    protected $connection = 'seguridad';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'url'
    ];

    /**
     * Un Sistema puede requerir varios permisos
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permisos() {
        return $this->belongsToMany(Permission::class, 'dbo.sistemas_permisos', 'sistema_id', 'permission_id');
    }
}