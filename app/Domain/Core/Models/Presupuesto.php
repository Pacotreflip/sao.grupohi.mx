<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 07/03/2018
 * Time: 01:20 PM
 */

namespace Ghi\Domain\Core\Models;


use Ghi\Domain\Core\Models\Transacciones\CotizacionContrato;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Presupuesto
 * @package Ghi\Domain\Core\Models
 */
class Presupuesto extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cadeco';

    /**
     * name data base
     * @var string
     */
    protected $table = 'dbo.presupuestos';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'id_transaccion',
        'id_concepto',
        'precio_unitario',
        'precio_material',
        'precio_mano_obra',
        'materiales',
        'mano_obra',
        'ind_material',
        'ind_mano_obra',
        'ind_total',
        'consumibles',
        'herramienta',
        'desperdicio',
        'id_destino',
        'no_cotizado',
        'PorcentajeDescuento',
        'IdMoneda',
        'Observaciones',
        'cantidad_contratista',
    ];

    public function contrato() {
        return $this->belongsTo(Contrato::class, 'id_concepto', 'id_concepto');
    }

    public function cotizacionContrato() {
        return $this->belongsTo(CotizacionContrato::class, 'id_transaccion', 'id_transaccion');
    }

    public function getPrecioUnitarioAntesDescuentoAttribute() {
        $precio_unitario = $this->precio_unitario;
        $descuento = $this->PorcentajeDescuento;

        switch ($this->IdMoneda) {
            case Moneda::PESOS :
                $res = (($precio_unitario * 100) / (100 - $descuento));
                break;
            case Moneda::DOLARES :
                $res = (($precio_unitario * 100) / (100 - $descuento)) / $this->cotizacionContrato->TcUSD;
                break;
            case Moneda::EUROS :
                $res = (($precio_unitario * 100) / (100 - $descuento)) / $this->cotizacionContrato->TcEuro;
                break;
            default :
                $res = $precio_unitario;
        }
        return $res;
    }

    public function getPrecioUnitarioDespuesDescuentoAttribute() {
        $precio_unitario = $this->precio_unitario;

        switch ($this->IdMoneda) {
            case Moneda::PESOS :
                $res = $precio_unitario;
                break;
            case Moneda::DOLARES :
                $res = $precio_unitario / $this->cotizacionContrato->TcUSD;
                break;
            case Moneda::EUROS :
                $res = $precio_unitario / $this->cotizacionContrato->TcEuro;
                break;
            default :
                $res = $precio_unitario;
        }
        return $res;
    }

    public function getPrecioTotalAntesDescuentoAttribute() {
        $cantidad_presupuestada_contrato = $this->contrato->cantidad_presupuestada;
        $precio_unitario = $this->precio_unitario;
        $descuento = $this->PorcentajeDescuento;

        switch ($this->IdMoneda) {
            case Moneda::PESOS :
                $res = (($cantidad_presupuestada_contrato * $precio_unitario * 100) / (100 - $descuento));
                break;
            case Moneda::DOLARES :
                $res = (($cantidad_presupuestada_contrato * $precio_unitario * 100) / (100 - $descuento)) / $this->cotizacionContrato->TcUSD;
                break;
            case Moneda::EUROS :
                $res = (($cantidad_presupuestada_contrato * $precio_unitario * 100) / (100 - $descuento)) / $this->cotizacionContrato->TcEuro;
                break;
            default :
                $res = $cantidad_presupuestada_contrato * $precio_unitario;
        }
        return $res;
    }

    public function getPrecioTotalDespuesDescuentoAttribute() {
        $cantidad_presupuestada_contrato = $this->contrato->cantidad_presupuestada;
        $precio_unitario = $this->precio_unitario;

        switch ($this->IdMoneda) {
            case Moneda::PESOS :
                $res = $cantidad_presupuestada_contrato * $precio_unitario;
                break;
            case Moneda::DOLARES :
                $res = ($cantidad_presupuestada_contrato * $precio_unitario) / $this->cotizacionContrato->TcUSD;
                break;
            case Moneda::EUROS :
                $res = ($cantidad_presupuestada_contrato * $precio_unitario) / $this->cotizacionContrato->TcEuro;
                break;
            default :
                $res = $cantidad_presupuestada_contrato * $precio_unitario;
        }
        return $res;
    }

    public function moneda() {
        return $this->belongsTo(Moneda::class, 'IdMoneda');
    }


}