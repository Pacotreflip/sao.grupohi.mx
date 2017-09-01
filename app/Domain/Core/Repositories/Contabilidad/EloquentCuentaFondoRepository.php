<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaFondoRepository;
use Ghi\Domain\Core\Models\Contabilidad\CuentaFondo;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class EloquentCuentaFondoRepository implements CuentaFondoRepository
{
    /**
     * @var CuentaFondo
     */
    protected $model;


    /**
     * EloquentCuentaFondoRepository constructor.
     * @param CuentaFondo $model
     */
    public function __construct(CuentaFondo $model)
    {
        $this->model = $model;
    }

    /**
     * Guarda un registro de cuenta de fondo
     * @param array $data
     * @return CuentaFondo
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
     * Actualiza un registro de cuenta de fondo
     * @param array $data
     * @param $id
     * @return CuentaFondo
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            if (! $old = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la Cuenta del Almacén que se desea Actualizar', 404));
            }

            if($old->cuenta == $data['cuenta']) {
                throw new HttpResponseException(new Response('La cuenta de Almacén que intentas actualizar es la misma', 404));
            }

            $new = $this->model->create([
                'id_fondo' => $old->id_fondo,
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