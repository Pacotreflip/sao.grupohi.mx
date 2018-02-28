<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 05/07/2017
 * Time: 12:07 PM
 * User: EMARTINEZ
 * Date: 05/07/2017
 * Time: 01:51 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Contracts\Ghi;
use Ghi\Domain\Core\Contracts\MaterialRepository;
use Ghi\Domain\Core\Contracts\valor;
use Ghi\Domain\Core\Models\Material;
use Illuminate\Support\Facades\DB;

class EloquentMaterialRepository implements MaterialRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Material
     */
    protected $model;

    /**
     * EloquentMaterialRepository constructor.
     * @param \Ghi\Domain\Core\Models\Material $model
     */
    public function __construct(Material $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Material
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Material
    /**
     * @param
     * @return Ghi\Domain\Core\Models\Material
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Buscar materiales
     * @param $attribute
     * @param $operator
     * @param $value
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Material
     */
    public function getBy($attribute, $operator, $value)
    {
        return $this->model->where($attribute, $operator, $value)->get();
    }

    /**
     * Obtiene un scope sobre el modelo
     * @param string $scope
     * @return mixed
     */
    public function scope($scope)
    {
        $this->model = $this->model->$scope();
        return $this;
    }

    /**
     * @param $value valor de busqueda de materiales de acuerdo a su tipo
     * @return mixed
     */
    public function findBy($value)
    {
        return $this->model->where('tipo_material', $value)->orderBy('nivel', 'asc')->get();
    }

    /**
     * @param $value los datos de busqueda para un material padre y materiales hijos
     * @return mixed
     */
    public function find($tipo, $nivel = null)
    {
        if ($nivel) {
            return $this->model->where(function ($query) use ($tipo, $nivel) {
                $query->orWhere('nivel', 'LIKE', $nivel)
                    ->orWhere('nivel', 'LIKE', $nivel . '___.');
            })->where('tipo_material', $tipo)->orderBy('nivel', 'asc')->get();
        }
        return $this->model->find($tipo);
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
     * Obtiene el nivel siguiente disponible de un tipo de material
     * @param $tipo
     * @return string
     */
    public function getNivelDisponible($tipo, $nivel = null)
    {
        if ($nivel) {
            $niveles = $this->model->where('nivel', 'like', $nivel . '___.')->where('tipo_material', '=', $tipo)->orderBy('nivel')->get();

            for ($i = 0; $i < $niveles->count(); $i++) {
                $nivel_str = explode('.', $niveles[$i]->nivel)[1];
                if ($i != intval($nivel_str)) {
                    return explode('.', $niveles[$i]->nivel)[0] . '.' . str_pad($i, 3, '0', STR_PAD_LEFT) . '.';
                }
            }
            if ($niveles->count() > 0) {
                return explode('.', $niveles[0]->nivel)[0] . '.' . str_pad($i, 3, '0', STR_PAD_LEFT) . '.';
            } else {
                return $nivel . str_pad($i, 3, '0', STR_PAD_LEFT) . '.';
            }
        } else {
            $niveles = $this->model->familias()->where('tipo_material', '=', $tipo)->orderBy('nivel')->get(['nivel']);
            for ($i = 0; $i < $niveles->count(); $i++) {
                if ($i != intval($niveles[$i]->nivel)) {
                    return str_pad($i, 3, '0', STR_PAD_LEFT) . '.';
                }
            }
            return str_pad($i, 3, '0', STR_PAD_LEFT) . '.';
        }
    }

    /**
     * @param array $data
     * @return Material
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            //dd($data['nivel']);
            DB::connection('cadeco')->beginTransaction();
            if ($data['nivel']) {
                $data['nivel'] = $this->getNivelDisponible($data['tipo_material'], $data['nivel']);
            } else {
                $data['nivel'] = $this->getNivelDisponible($data['tipo_material'], null);
            }
            $data['UsuarioRegistro'] = auth()->user()->idusuario;


            $material = $this->model->create($data);
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            //dd($e);
            throw $e;
        }
        return $material;
    }

    /**
     * Actualiza el material seleccionado
     * @param $data
     * @param $id
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     */
    public function update($data, $id)
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * Elimina el material seleccionado
     * @param $data
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            if (!$item = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la plantilla que se desea eliminar', 404));
            }
            $item->destroy($id);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
    }

    /**
     * Obtiene todas las familias de materiales que sean del tipo $tipo
     * @param $tipo
     * @return Collection|Material
     */
    public function getFamiliasByTipo($tipo)
    {
        return $this->model->where('nivel', 'like', Material::NIVEL_FAMILIA)
            ->where('tipo_material', '=', $tipo)
            ->get();
    }

    /**
     * Obtiene los hijos de un material
     * @param $id
     * @return Collection|Material
     */
    public function getHijos($id)
    {
        $padre = Material::find($id);
        return $this->model->where('nivel', 'like', $padre->nivel_hijos)
            ->where('tipo_material', '=', $padre->tipo_material)
            ->get();
    }

    public function getDescripcionByTipo($descripcion, $tipo)
    {
        return $this->model->where('descripcion', 'like', '%' . $descripcion . '%')
            ->where('tipo_material', '=', $tipo)
            ->whereRaw('LEN(nivel) > 4')
            ->limit(5)
            ->get();


    }

    public function getFamiliasByTipoPadres($descripcion, $tipo)
    {
        return $this->model->where('descripcion', 'like', '%' . $descripcion . '%')
            ->where('tipo_material', '=', $tipo)
            ->whereRaw('LEN(nivel) <=4')
            ->get();


    }
}