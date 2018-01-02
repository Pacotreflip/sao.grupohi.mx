<?php
namespace Ghi\Domain\Core\Repositories\Seguridad;

use Ghi\Domain\Core\Contracts\Seguridad\CierreRepository;
use Ghi\Domain\Core\Models\Seguridad\Cierre;
use Illuminate\Database\Eloquent\Collection;

class EloquentCierreRepository implements CierreRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto
     */
    protected $model;

    public function __construct(Cierre $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de dias Cierre
     *
     * @return Collection | Cierre
     */
    public function all() {
        return $this->model->get();
    }

    public function paginate(array $data) {
        $query = $this->model->with('userRegistro')->select('Configuracion.cierres.*')->orderBy('Configuracion.cierres.created_at', 'DESC');
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    public function create(array $data) {
        $cierre = $this->model->create($data);
        return $cierre;
    }

    public function find($id) {
        $cierre = $this->model->find($id);
        return $cierre;
    }
}