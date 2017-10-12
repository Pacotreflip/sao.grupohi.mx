<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Contracts\Contabilidad\TraspasoCuentasRepository;
use Ghi\Domain\Core\Models\Contabilidad\TraspasoCuentas;

class EloquentTraspasoCuentasRepository implements TraspasoCuentasRepository
{
    /**
     * @var TraspasoCuentas $model
     */
    private $model;

    /**
     * EloquentTraspasoCuentasRepository constructor.
     * @param TransaccionInterfaz $model
     */
    public function __construct(TraspasoCuentas $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Contabilidad\TraspasoCuentas
     */
    public function all()
    {
        return $this->model->get();
    }

    public function cuentas()
    {
        $cuentas = DB::connection('cadeco')
            ->table('cuentas')
            ->join('empresas', 'empresas.id_empresa', '=', 'cuentas.id_empresa')
            ->select('empresas.*', 'cuentas.*')
            ->where('tipo_empresa', 8)
            ->where('cuentas.cuenta_contable', 'like', '%[0-9\-]%')
            ->whereRaw("ISNUMERIC(numero) = 1")
            ->get();

        return $cuentas;
    }

    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $modelo = $this->model;

            $modelo->save();

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $this->find($modelo->id);
    }
}
