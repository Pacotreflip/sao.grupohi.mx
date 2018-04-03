<?php

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;

use \Ghi\Domain\Core\Models\ControlPresupuesto\CambioInsumos;

interface CambioCantidadInsumosRepository
{
    /**
     * Obtiene todos los registros de CambioCantidadInsumos
     * @return CambioInsumos
     */
    public function all();
    /**
     * Guarda un registro de CambioInsumos
     * @param array $data
     * @throws \Exception
     * @return CambioInsumos
     */
    /**
     * Regresa un registro específico de CambioCantidadInsumos
     * @param $id
     * @return CambioCantidadInsumos
     */
    public function find($id);

    public function with($relations);

    public function create(array $data);
    public function getAgrupacionFiltro(array $data);
    public function getExplosionAgrupados(array $data);
    public function getExplosionAgrupadosPartidas(array $data);
    public function getAgrupacionFiltroPartidas(array $data);
    public function rechazar(array $data);
    public function autorizar($id);
    public function getAfectacionesSolicitud($id);
}