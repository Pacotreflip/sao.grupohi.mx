<?php namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaConceptoRepository;
use Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EloquentCuentaConceptoRepository implements CuentaConceptoRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto
     */
    protected $model;

    /**
     * EloquentCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto $model
     */
    public function __construct(CuentaConcepto $model)
    {
        $this->model = $model;
    }

    /**
     * Guarda un registro de cuenta concepto
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $data['registro'] = auth()->user()->idusuario;
            $item = $this->model->create($data);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $item;
    }

    /**
     * Actualiza un registro de cuenta concepto
     * @param array $data
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            if (! $old = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la Cuenta del Concepto que se desea Actualizar', 404));
            }
            if($old->cuenta == $data['cuenta']) {
                throw new HttpResponseException(new Response('La cuenta Concepto que intentas actualizar es la misma', 404));
            }
            $new = $this->model->create([
                'id_concepto' => $old->id_concepto,
                'cuenta' => $data['cuenta'],
                'registro' => auth()->user()->idusuario
            ]);

            $old->update(['estatus' => 0]);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $new;
    }
}