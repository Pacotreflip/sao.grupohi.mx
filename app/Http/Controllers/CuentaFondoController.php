<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaConceptoRepository;
use Illuminate\Http\Request;

class CuentaFondoController extends Controller
{

    use Helpers;

    public function index()
    {
        //$fondos = $this->fondo->all();

        return view('sistema_contable.cuenta_fondo.index');
            //->withConceptos($conceptos);
    }
}
