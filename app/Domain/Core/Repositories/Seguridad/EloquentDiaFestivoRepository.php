<?php
namespace Ghi\Domain\Core\Repositories\Seguridad;
use Ghi\Domain\Core\Contracts\Seguridad\DiaFestivoRepository;
use Ghi\Domain\Core\Contracts\Seguridad\Identificador;
use Ghi\Domain\Core\Models\Seguridad\DiaFestivo;

class EloquentDiaFestivoRepository implements DiaFestivoRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto
     */
    protected $model;

    /**
     * EloquentCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto $model
     */
    public function __construct(DiaFestivo $model)
    {
        $this->model = $model;
    }


    /**
     * Obtiene todos los registros de dias festivos
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Seguridad\DiaFestivoRepository
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id Identificador del dia festivo
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Seguridad\DiaFestivoRepository
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }
}