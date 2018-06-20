<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/06/2018
 * Time: 01:12 PM
 */

namespace Ghi\Domain\Core\Models\Finanzas;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CTGTipoSolicitud
 * @package Ghi\Domain\Core\Models\Finanzas
 */
class CTGTipoSolicitud extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'cadeco';
    /**
     * @var string
     */
    protected $table = 'Finanzas.ctg_tipos_solicitud';

    /**
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'descripcion_corta',
    ];
}