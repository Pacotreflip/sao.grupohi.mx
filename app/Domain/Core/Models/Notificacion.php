<?php
namespace Ghi\Domain\Core\Models;


use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.notificaciones';
    protected $fillable =
        [
            'titulo',
            'contenido',
            'id_usuario',
            'id_obra'
        ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ObraScope());
    }

    public function __construct(array $attributes = [])
    {
        $attributes['id_obra'] = Context::getId();
        parent::__construct($attributes);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function obra() {
        return $this->belongsTo(\Ghi\Core\Models\Obra::class, 'id_obra');
    }

}