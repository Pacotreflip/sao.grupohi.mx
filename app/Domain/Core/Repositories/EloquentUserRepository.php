<?php

namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Models\Obra;
use Ghidev\Core\Models\User;
use Illuminate\Config\Repository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Ghi\Core\Models\BaseDatosCadeco;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Models\UsuarioCadeco;


class EloquentUserRepository extends \Ghi\Core\Repositories\EloquentUserRepository implements \Ghi\Domain\Core\Contracts\UserRepository
{

    private $config;

    /**
     * EloquentUserRepositoryApi constructor.
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Obtiene un usuario por su id
     *
     * @param $id
     * @return User
     */
    public function getById($id)
    {
        return User::where('idusuario', $id)->firstOrFail();
    }

    /**
     * Obtiene un usuario por su nombre de usuario
     *
     * @param $nombre
     * @return User
     */
    public function getByNombreUsuario($nombre)
    {
        return User::where('usuario', $nombre)->firstOrFail();
    }

    /**
     * Obtiene el usuario cadeco asociado al usuario de intranet
     *
     * @param $idUsuario
     * @return UsuarioCadeco
     */
    public function getUsuarioCadeco($id_usuario)
    {
        $usuario = $this->getById($id_usuario);

        return UsuarioCadeco::where('usuario', $usuario->usuario)->first();
    }

    /**
     * Obtiene las obras de un usuario cadeco de todas las bases de datos definidas
     *
     * @param $idUsuario
     * @return Collection|Obra
     */
    public function getObras($idUsuario)
    {
        $obrasUsuario = new Collection();

        $basesDatos = BaseDatosCadeco::where('activa', true)->orderBy('nombre')->get();

        foreach ($basesDatos as $bd) {
            $this->config->set('database.connections.cadeco.database', $bd->nombre);

            $usuarioCadeco = $this->getUsuarioCadeco($idUsuario);

            $obras = $this->getObrasUsuario($usuarioCadeco);

            foreach ($obras as $obra) {
                $obra->databaseName = $bd->nombre;

                $obrasUsuario->push($obra);
            }

            DB::disconnect('cadeco');
        }

        $perPage     = 10;
        $currentPage = Paginator::resolveCurrentPage();
        $currentPage = $currentPage ? $currentPage : 1;
        $offset      = ($currentPage * $perPage) - $perPage;

        $paginator = new LengthAwarePaginator(
            $obrasUsuario->slice($offset, $perPage),
            $obrasUsuario->count(),
            $perPage
        );

        return $paginator;
    }

    /**
     * Obtiene las obras de un usuario cadeco
     *
     * @param UsuarioCadeco $usuarioCadeco
     * @return \Illuminate\Database\Eloquent\Collection|Obra
     */
    private function getObrasUsuario($usuarioCadeco)
    {
        if (! $usuarioCadeco) {
            return [];
        }

        if ($usuarioCadeco->tieneAccesoATodasLasObras()) {
            return Obra::orderBy('nombre')->get();
        }

        return $usuarioCadeco->obras()->orderBy('nombre')->get();
    }
}