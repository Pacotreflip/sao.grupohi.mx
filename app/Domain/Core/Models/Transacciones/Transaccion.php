<?php

namespace Ghi\Domain\Core\Models\Transacciones;

use Ghi\Domain\Core\Models\TipoTransaccion;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cadeco';

    /**
     * @var string
     */
    protected $table = 'dbo.transacciones';

    /**
     * @var string
     */
    protected $primaryKey = 'id_transaccion';

    /**
     * @var bool
     */
    public $timestamps = false;

    protected $dates=['fecha'];

    protected $fillable = [
        'tipo_transaccion',
        'fecha',
        'estado',
        'id_obra',
        'id_cuenta',
        'id_moneda',
        'cumplimiento',
        'vencimiento',
        'opciones',
        'monto',
        'referencia',
        'comentario',
        'observaciones',
        'FechaHoraRegistro',
    ];

    /**
     * Items relacionados con esta transaccion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Item
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'id_transaccion', 'id_transaccion');
    }

      public function tipoTransaccion(){

        return $this->belongsTo(TipoTransaccion::class, 'tipo_transaccion', 'tipo_transaccion')->where('opciones','=',$this->opciones);
    }

    public function getAppends() {
        $vars = get_class_vars(__CLASS__);
        return $vars['appends'];
    }
}
