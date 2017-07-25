<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Core\Models\BaseDatosCadeco;
use Ghi\Domain\Core\Contracts\ObraRepository;
use Ghi\Domain\Core\Models\Obra;
use Ghi\Domain\Core\Models\Seguridad\Proyecto;
use Ghi\Domain\Core\Models\UsuarioCadeco;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObraController extends Controller
{
    use Helpers;

    private $config;

    /**
     * ItemController constructor.
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;

        parent::__construct();

        $this->middleware('auth');

    }

    public function search(Request $request)
    {
        $obrasUsuario = new Collection();

        $basesDatos = Proyecto::orderBy('description')->get();

        foreach ($basesDatos as $bd) {
            $this->config->set('database.connections.cadeco.database', $bd->base_datos);

            $usuarioCadeco = UsuarioCadeco::where('usuario', auth()->user()->usuario)->first();

            $obras = $this->getObrasUsuario($usuarioCadeco, $request->q);

            foreach ($obras as $obra) {
                $obra->databaseName = $bd->base_datos;

                $obrasUsuario->push($obra);
            }

            DB::disconnect('cadeco');
        }

        return $this->response->array($obrasUsuario);
    }

    /**
     * Obtiene las obras de un usuario cadeco
     *
     * @param UsuarioCadeco $usuarioCadeco
     * @return \Illuminate\Database\Eloquent\Collection|Obra
     */
    private function getObrasUsuario($usuarioCadeco, $q)
    {
        if (!$usuarioCadeco) {
            return [];
        }

        if ($usuarioCadeco->tieneAccesoATodasLasObras()) {
            return Obra::where('nombre', 'like', '%'.$q.'%')->orderBy('nombre')->get();
        }

        return $usuarioCadeco->obras()->where('nombre', 'like', '%'.$q.'%')->orderBy('nombre')->get();
    }
}
