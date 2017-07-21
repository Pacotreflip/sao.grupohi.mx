<?php
namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface NotificacionPolizaRepository
{
    /**
     * Obtiene todos los registros de la notificacion
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\NotificacionPoliza
     */
    public function all();

    /**
     * @param $id Identificador de notificacion Poliza
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\NotificacionPoliza
     */
    public function find($id);
    /**
     * Guarda un registro de Item
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\NotificacionPoliza
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations);


    public function findBy($attribute, $value, $columns = array('*'));
    /**
     *  Contiene los parametros de búsqueda
     * @param array $where
     * @return mixed
     */
    public function where($where);
   }