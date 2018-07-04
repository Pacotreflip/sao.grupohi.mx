<?php

namespace Ghi\Domain\Core\Models\Transacciones;

use Carbon\Carbon;
use Ghi\Domain\Core\Models\Contabilidad\Cierre;
use Ghi\Domain\Core\Models\Contabilidad\Factura;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Moneda;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\TipoTransaccion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

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

    protected $dates=['fecha', 'vencimiento'];

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
        'impuesto',
        'referencia',
        'comentario',
        'observaciones',
        'FechaHoraRegistro',
        'numero_folio',
    ];



    protected $appends = ['tipo_transaccion_string', 'tipo_cambio'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model){

            if(!self::periodoAbierto($model->fecha)) {
                throw new HttpResponseException(new Response('No se puede registrar la transacción ya que el periodo actual presenta un Cierre', 400, ['next-date' => $proxima_fecha->toDateString()]));
            }
        });
    }

    /**
     * Items relacionados con esta transaccion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Item
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'id_transaccion', 'id_transaccion');
    }

      public function tipoTran(){

        return $this->belongsTo(TipoTransaccion::class, 'tipo_transaccion', 'tipo_transaccion')->where('opciones','=',$this->opciones);
    }

    public function getTipoTransaccionStringAttribute() {
          return (String) $this->tipoTran;
    }

    public function getTieneFacturasAttribute() {
        $facturas = Factura::whereHas('items', function ($q) {
            $q->whereIn('id_antecedente', $this->items()->get(['id_item'])->toArray());
        })->get();

        return count($facturas) ? true : false;

    }

    public function getAppends() {
        $vars = get_class_vars(__CLASS__);
        return $vars['appends'];
    }

    public static function periodoAbierto($fecha) {
        $date = new Carbon($fecha);

        if($cierre = Cierre::where('anio', '=', $date->year)->where('mes', '=', $date->month)->first()) {
            //Si el cierre devuelto esta cerrado para registro
            if(! $cierre->abierto) {

                $proxima_fecha = null;
                //Agregamos un Mes a la fecha para evaluar el siguiente periodo
                $date->day = 1;


                //Buscamos el proximo periodo que no presente cierres o se encuentre abierto
                for($abierto = false; $abierto != true; $date->addMonth()) {
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
                return false;
            }
            return true;
        }
        return true;
    }

    public function moneda() {
        return $this->belongsTo(Moneda::class, 'id_moneda');
    }

    public function getTipoCambioAttribute() {
        switch ($this->moneda->id_moneda) {
            case Moneda::PESOS:
                return 1;
                break;
            case Moneda::EUROS:
                return $this->TcEuro;
                break;
            case Moneda::DOLARES:
                return $this->TcUSD;
                break;
            default:
                return null;
                break;
        }
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function getRangoVencimientoAttribute() {

    }
}
