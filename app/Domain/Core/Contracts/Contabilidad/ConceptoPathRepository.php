<?php

namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface ConceptoPathRepository
{
    public function filtrar($raw);
    public function filtrarConMovimiento($raw);
}