<?php namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\DatosContablesRepository;
use Ghi\Domain\Core\Models\Contabilidad\DatosContables;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EloquentDatosContablesRepository implements DatosContablesRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Contabilidad\DatosContables
     */
    private $model;

    public function __construct(DatosContables $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene los datos contables de una obra que coincidan con los atributos de búsqueda
     * @param string $attribute
     * @param mixed $value
     * @return \Ghi\Domain\Core\Models\Contabilidad\DatosContables
     */
    public function findBy($attribute, $value) {
        return $this->model->where($attribute, '=', $value)->first();
    }

    /**
     * Actualiza la los datos contables de una obra
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\DatosContables
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            if (!$item = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontraron los Datos Contables que se desean Actualizar', 404));
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
        } catch (\Exception $e) {+
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $item;
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

    /**
     * Buscar datos contables por su id
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
}