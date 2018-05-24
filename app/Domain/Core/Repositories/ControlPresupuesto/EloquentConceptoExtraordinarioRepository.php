<?php
/**
 * Created by PhpStorm.
 * User: 25852
 * Date: 18/05/2018
 * Time: 04:53 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\ConceptoExtraordinarioRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoTarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\Tarjeta;

class EloquentConceptoExtraordinarioRepository implements ConceptoExtraordinarioRepository
{

    public function getDesdeTarjeta($id_tarjeta)
    {

    }
}