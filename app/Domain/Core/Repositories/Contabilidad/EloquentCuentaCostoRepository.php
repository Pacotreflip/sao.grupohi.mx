<?php namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaCostoRepository;
use Ghi\Domain\Core\Models\Contabilidad\CuentaCosto;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EloquentCuentaCostoRepository implements CuentaCostoRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Contabilidad\CuentaCosto
     */
    protected $model;

    /**
     * EloquentCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\Contabilidad\CuentaCosto $model
     */
    public function __construct(CuentaCosto $model)
    {
        $this->model = $model;
    }

    /**
     * Guarda un registro de cuenta concepto
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaCosto
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
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaCosto
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            if (! $old = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la Cuenta del Costo que se desea Actualizar', 404));
            }
            if($old->cuenta == $data['data']['cuenta']) {
                throw new HttpResponseException(new Response('La cuenta costo que intentas actualizar es la misma', 404));
            }
            $new = $this->model->create([
                'id_costo' => $old->id_costo,
                'cuenta' => $data['data']['cuenta'],
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

    public function delete($id)
    {
        // Define el error a mostrar
        $error = 'No se encontró la cuenta contable que se desea eliminar';
        $already = 'La cuenta ya se ha eliminado anteriormente';

        try {
            $item = $this->model->find($id);

            if (!$item)
            {
                throw new HttpResponseException(new Response($error, 404));

                return $error;
            }

            // Ya se ha eliminado anteriormente
            if ($item->estatus == 0)
            {
                throw new HttpResponseException(new Response($already, 404));

                return $already;
            }

            DB::connection('cadeco')->beginTransaction();
            $item->update(['estatus' => 0]);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $id;
    }
}