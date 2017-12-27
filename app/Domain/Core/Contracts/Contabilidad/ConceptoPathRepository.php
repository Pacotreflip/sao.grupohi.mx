<?php

namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface ConceptoPathRepository
{
    public function buscarCostoTotal($raw);
}