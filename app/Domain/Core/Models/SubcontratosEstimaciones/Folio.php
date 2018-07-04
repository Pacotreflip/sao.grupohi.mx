<?php

namespace Ghi\Domain\Core\Models\SubcontratosEstimaciones;

use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'SubcontratosEstimaciones.FolioPorSubcontrato';
    protected $primaryKey = 'IDSubcontrato';
    protected $fillable = [
        'IDObra',
        'IDSubcontrato',
        'UltimoFolio'
    ];
    public $timestamps = false;
}
