<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\ObraRepository;
use Ghi\Domain\Core\Models\Obra;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EloquentObraRepository implements ObraRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Obra
     */
    private $model;

    /**
     * EloquentObraRepository constructor.
     * @param \Ghi\Domain\Core\Models\Obra $model
     */
    public function __construct(Obra $model)
    {
        $this->model = $model;
    }

    /**
     * Actualiza la información de la obra
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Obra
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            if (!$item = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la Obra que se desea Actualizar', 404));
            }

            if ($data['FormatoCuenta']) {
                $regExp = "^";
                $formato = explode("-", $data['FormatoCuenta']);
                foreach ($formato as $i => $d) {
                    if ($i == count($formato) - 1) {
                        $regExp .= "\d{" . strlen($d) . "}";
                    } else {
                        $regExp .= "\d{" . strlen($d) . "}-";
                    }
                }
                $regExp .= "$";

                $data['FormatoCuentaRegExp'] = $regExp;
            }

            $item->update($data);
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $item;
    }

    /**
     * Busca y devuelve la obra por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\Obra
     * @throws \Exception
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     * @internal param array $array
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }
}