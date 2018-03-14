<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 07/03/2018
 * Time: 10:47 AM
 */

namespace Ghi\Domain\Core\Formatos\Contratos;

use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;
use Ghidev\Fpdf\Rotation;

class ComparativaPresupuestos extends Rotation
{
    const MAX_COTIZACIONES_PP = 5;
    /**
     * @var ContratoProyectado
     */
    protected $contrato_proyectado;

    /**
     * @var array
     */
    var $contratos;

    /**
     * @var array
     */
    var $cotizaciones;

    /**
     * @var int
     */
    var $num_cotizaciones;

    /**
     * ComparativaPresupuestos constructor.
     * @param ContratoProyectado $contrato_proyectado
     */
    public function __construct(ContratoProyectado $contrato_proyectado) {
        parent::__construct('L', 'cm', 'A3');

        $this->contrato_proyectado = $contrato_proyectado;
        $this->contratos = $contrato_proyectado->contratos()->orderBy('nivel')->get()->toArray();
        $this->cotizaciones = $contrato_proyectado->cotizacionesContrato()->with('presupuestos')->orderBy('monto')->get()->toArray();
        $this->num_cotizaciones = count($this->cotizaciones);
    }

    function Header() {

    }

    protected function items($page) {
        $this->encabezadosTabla($page);
    }

    protected function encabezadosTabla($page) {

    }

    function Footer() {

    }

    public function create() {
        $this->SetMargins(1, 0.5, 1);
        $this->AliasNbPages();
        $this->AddPage();

        $this->SetFont('Arial');
        for($i = 0; $i < ceil($this->num_cotizaciones / self::MAX_COTIZACIONES_PP); $i++) {
            $this->items($this->PageNo());
            $this->AddPage();
        }

        try {
            $this->Output('I', 'Formato - Comparativa de Presupestos.pdf', 1);
        } catch (\Exception $ex) {
            dd($ex);
        }
        exit;
    }
}