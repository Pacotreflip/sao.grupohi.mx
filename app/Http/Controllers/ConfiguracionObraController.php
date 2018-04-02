<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Seguridad\ConfiguracionObraRepository;
use Ghi\Domain\Core\Models\Seguridad\ConfiguracionObra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Ghi\Http\Requests;

/**
 * Class ConfiguracionObraController
 * @package Ghi\Http\Controllers
 */
class ConfiguracionObraController extends Controller
{
    /**
     *
     */
    use Helpers;
    /**
     * @var ConfiguracionObraRepository
     */
    protected $configuracionObraRepository;

    /**
     * ConfiguracionObraController constructor.
     * @param ConfiguracionObraRepository $configuracionObraRepository
     */
    public function __construct(ConfiguracionObraRepository $configuracionObraRepository)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');
        //$this->middleware('verify.logo');
        $this->middleware('permission:administrar_roles_permisos', ['only' => ['store', 'update']]);

        $this->configuracionObraRepository = $configuracionObraRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $config = $this->configuracionObraRepository->all()->toArray();
        if($config) {
            $config[0]['logotipo_original'] = $this->getImagen($config[0]['logotipo_original']);
            $config[0]['logotipo_reportes'] = $this->getImagen($config[0]['logotipo_reportes']);
            return response()->json([
                $config[0],
            ], 200);
        }else{
            return response()->json(['error' => 'error'], 404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function insert(Request $request)
    {

        $config = $this->configuracionObraRepository->all()->toArray();
        if(!$config)
        {
            $data = $this->setImagen($request);
            $config = $this->configuracionObraRepository->create($data);
            if (!$config) {
                return response()->json(['error' => ''], 404);
            }
            return response()->json(['data' =>
                [
                    'config' => $config
                ]
            ], 200);
        }else{
            return $this->update($request,$config[0]['id']);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $data = $this->setImagen($request);
        $config = $this->configuracionObraRepository->update($data, $id);
        if(!$config){
            return response()->json($id, 404);
        }
        $config = $config->toArray();
        $config['logotipo_original'] = $this->getImagen($config['logotipo_original']);
        $config['logotipo_reportes'] = $this->getImagen($config['logotipo_reportes']);
        return response()->json(['data' =>
            [
                'config' =>  $config
            ]
        ], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function delete(Request $request, $id)
    {
        $this->configuracionObraRepository->delete($id);
        return $this->response->accepted();
    }

    /**
     * @param Request $request
     * @return array
     */
    private function setImagen(Request $request){
        $file = $request->file('file');
        $imageData = unpack("H*", file_get_contents($file->getPathname()));
        $data['logotipo_original']= DB::raw("CONVERT(VARBINARY(MAX), '".$imageData[1]."')");
        $data['logotipo_reportes']= DB::raw("CONVERT(VARBINARY(MAX), '".$imageData[1]."')");
        $data['vigencia']= 1;
        return $data;
    }

    /**
     * @param string $imagen
     * @return string
     */
    private function getImagen($imagen = ''){
        $bin = '';
        $data = pack('H*', hex2bin($imagen));
        $file = public_path('img/logo_temp.png');
        if (file_put_contents($file, $data)){
            $bin = base64_encode($data);;
            unlink($file);
        }
        return $bin;
    }
}
