<?php
namespace Ghi\Domain\Core\Repositories\Compras;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Ghi\Domain\Core\Models\Compras\Requisiciones\TransaccionExt;
use Illuminate\Support\Facades\DB;

class EloquentRequisicionRepository implements RequisicionRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion
     */
    protected $model;

    /**
     * @var \Ghi\Domain\Core\Models\Compras\Requisiciones\TransaccionExt
     */
    protected $ext;

    /**
     * EloquentRequisicionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion $model
     */
        public function __construct(Requisicion $model, TransaccionExt $ext)
    {
        $this->model = $model;
        $this->ext = $ext;
    }
    /**
     * Obtiene todos los registros de Requisicion
     *
     * @return \Illuminate\Database\Eloquent\Collection|Requisicion
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|Requisicion

     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Guarda un registro de Transaccion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $item = $this->model->create($data);

            $this->ext->create([
                'id_transaccion' => $item->id_transaccion,
                'id_departamento' => $data['id_departamento'],
                'id_tipo_requisicion' => $data['id_tipo_requisicion']
            ]);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $item;
    }
}