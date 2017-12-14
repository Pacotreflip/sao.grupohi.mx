<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 01/12/2017
 * Time: 01:55 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Carbon\Carbon;
use Dingo\Api\Facade\Route;
use Ghi\Domain\Core\Contracts\ConciliacionRepository;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Contracts\ContratoProyectadoRepository;
use Ghi\Domain\Core\Contracts\ContratoRepository;
use Ghi\Domain\Core\Contracts\EmpresaRepository;
use Ghi\Domain\Core\Contracts\EstimacionRepository;
use Ghi\Domain\Core\Contracts\ItemRepository;
use Ghi\Domain\Core\Contracts\SubcontratoRepository;
use Ghi\Domain\Core\Models\Acarreos\MaterialAcarreo;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Acarreos\ContratoProyectadoAcarreo;
use Ghi\Domain\Core\Models\Moneda;
use Ghi\Domain\Core\Models\Transacciones\Item;
use Ghi\Domain\Core\Models\Transacciones\Subcontrato;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\User;
use function MongoDB\BSON\toJSON;

class EloquentConciliacionRepository implements ConciliacionRepository
{


    /**
     * @var EmpresaRepository
     */
    var $empresa;

    /**
     * @var ContratoProyectadoRepository
     */
    var $contratoProyectado;

    /**
     * @var SubcontratoRepository
     */
    var $subcontrato;

    /**
     * @var ContratoRepository
     */
    var $contrato;

    /**
     * @var ItemRepository
     */
    var $item;

    /**
     * @var
     */
    var $estimacion;

    /**
     * EloquentConciliacionRepository constructor.
     * @param EmpresaRepository $empresa
     * @param ContratoProyectadoRepository $contratoProyectado
     * @param SubcontratoRepository $subcontrato
     * @param ContratoRepository $contrato
     * @param ItemRepository $item
     */
    public function __construct(EstimacionRepository $estimacion,EmpresaRepository $empresa, ContratoProyectadoRepository $contratoProyectado, SubcontratoRepository $subcontrato, ContratoRepository $contrato, ItemRepository $item)
    {
        $this->empresa = $empresa;
        $this->contratoProyectado = $contratoProyectado;
        $this->subcontrato = $subcontrato;
        $this->contrato = $contrato;
        $this->item = $item;
        $this->estimacion = $estimacion;
    }


    public function store(Request $request)
    {
        dd($request->all());

        $partidas_conciliacion = $request->get('partidas_conciliacion');
        $empresa = Empresa::where('rfc', '=', $request->rfc)->first();

        if(!$empresa){
            // si no existe -> crear empresa
            $empresa = $this->empresa->create($request);
        }
        //INICIO DE APARTADO DE CONTRATO PROYECTADO
        // si contrato proyectado no existe -> crear contrato proyectado y partidas
        if(!$contrato_proyectado = ContratoProyectadoAcarreo::where('estatus',1)->first()){
            //  -> crear Contrato proyectado con su contrato
            $req = new Request();
            $contratos = [];
            foreach ($partidas_conciliacion as $key => $partida){
                if($key<10)$llave = '00'.$key.'.';
                if($key>10 && $key<100)$llave = '0'.$key.'.';
                if($key>100)$llave = $key.'.';
                $contratos[$key] =  array(
                    'nivel' => $llave,
                    'descripcion' => 'Acarreo de Material '.$partida['material'],
                    'unidad' => 'M3',
                    'cantidad_presupuestada' => $partida['volumen'],
                    'id_material' => (int)$partida['id_material'],
                    'tarifa' => $partida['tarifa'],
                    'destinos' => array( [
                        'id_concepto' => (int)$partida['id_concepto']
                    ])
                );
            }

            $req->merge([
                'fecha' => Carbon::now()->toDateString(),
                'referencia' => 'Contrato Proyectado de Acarreos',
                'cumplimiento' => Carbon::now()->toDateString(),
                'vencimiento' => Carbon::now()->addYear(1)->toDateString(),
                'contratos' => ($contratos)

            ]);
            $contrato_proy_creado = $this->contratoProyectado->create($req);
            $contrato_proyectado = ContratoProyectadoAcarreo::create(['id_transaccion' => $contrato_proy_creado->id_transaccion, 'descripcion' => $contrato_proy_creado->referencia]);

        }else{  // si existe -> buscar contrato de cada partida
            foreach ($partidas_conciliacion as $key => $partida) {

                $contrato = Contrato::join('destinos', 'contratos.id_concepto', '=', 'destinos.id_concepto_contrato')
                    ->join('Acarreos.material', 'destinos.id_concepto_contrato', '=', 'Acarreos.material.id_concepto_contrato')
                    ->where('Acarreos.material.id_material_acarreo', '=', $partida['id_material'])
                    ->where('destinos.id_concepto', '=', (int)$partida['id_concepto'])->first();
                if (!$contrato) {  // si no existe contrato adjunto al Contrato proyectado, crearlo

                    $req = new Request();
                    $contratos = [];
                    $contratos[] =  array(
                        'nivel' => $this->getNivel($contrato_proyectado['id_transaccion']),
                        'descripcion' => 'Acarreo de Material '.$partida['material'],
                        'unidad' => 'M3',
                        'cantidad_presupuestada' => $partida['volumen'],
                        'id_material' => (int)$partida['id_material'],
                        'tarifa' => $partida['tarifa'],
                        'destinos' => array( [
                            'id_concepto' => (int)$partida['id_concepto']
                        ])
                    );

                    $req->merge([
                        'contratos' => ($contratos)
                    ]);
                    $this->contratoProyectado->addContratos($req,$contrato_proyectado['id_transaccion']);
                }
            }

        }  // FIN DE APARTADO DE CONTRATO PROYECTADO

        // INICIO DE APARTADO DE SUBCONTRATO
        // Buscar Subcontrato, si no existe crear Subcontrato con Items
        if(!$subcontrato = Subcontrato::where('id_antecedente', '=', $contrato_proyectado['id_transaccion'])->where('id_empresa', '=', $empresa->id_empresa)->first()){
            $req = new Request();
            $items = [];
            foreach ($partidas_conciliacion as $key => $partida){
                $concepto_contrato = MaterialAcarreo::select('id_concepto_contrato')->where('id_material_acarreo', '=',(int)$partida['id_material'])->where('id_concepto', '=',(int)$partida['id_concepto'] )->first();
                $moneda = Moneda::where('tipo', 1)->first();
                $items[$key] =  array(
                    'id_concepto' => $concepto_contrato->id_concepto_contrato,
                    'cantidad' => $partida['volumen'],
                    'precio_unitario' => $partida['tarifa']
                );
            }

            $req->merge([
                'id_antecedente' => $contrato_proyectado['id_transaccion'],
                'fecha' => Carbon::now()->toDateString(),
                'id_costo' => (int)$request->id_costo,
                'id_empresa' => $empresa->id_empresa,
                'id_moneda' => array_key_exists('id_moneda', $partida)? (int)$partida['id_moneda']:(int)$moneda->id_moneda,
                'referencia' => 'Subcontrato acarreos a '. $empresa->razon_social ,
                'items' => ($items)

            ]);
            $resp = $this->subcontrato->create($req);

            dd('subpandita nuevo', $resp);    //      -> crear subcontrato con items
        }else{   // si existe
            //      -> buscar Item

            foreach ($partidas_conciliacion as $key => $partida) {
                $item = Item::join('Acarreos.material', 'items.id_concepto', '=', 'Acarreos.material.id_concepto_contrato')
                    ->where('Acarreos.material.id_transaccion', '=', $contrato_proyectado['id_transaccion'])
                    ->where('Acarreos.material.id_material_acarreo', '=', (int)$partida['id_material'])
                    ->where('items.precio_unitario', '=', $partida['tarifa'])
                    ->select('items.id_item')->first();

                if ($item) {    //              si existe       -> aumentar volumen
                    $req = new Request();
                    $req->merge(['cantidad' => $partida['volumen'] ]);

                    $resp =$this->item->update($req, $item->id_item);
                } else {   //              no existe       -> crearlo

                    $req = new Request();
                    $contratos = [];
                    $contratos[] =  array(
                        'nivel' => $this->getNivel($contrato_proyectado['id_transaccion']),
                        'descripcion' => 'Acarreo de Material '.$partida['material'],
                        'unidad' => 'M3',
                        'cantidad_presupuestada' => $partida['volumen'],
                        'id_material' => (int)$partida['id_material'],
                        'tarifa' => $partida['tarifa'],
                        'destinos' => array( [
                            'id_concepto' => (int)$partida['id_concepto']
                        ])
                    );

                    $req->merge([
                        'contratos' => ($contratos)
                    ]);
                    $nuevo_contrato = $this->contratoProyectado->addContratos($req,$contrato_proyectado['id_transaccion']);

                    $req = new Request();
                    $req->merge([
                        'id_transaccion' => $subcontrato->id_transaccion,
                        'cantidad' => $partida['volumen'],
                        'precio_unitario' => $partida['tarifa'],
                        'id_concepto' => $nuevo_contrato[0]['id_concepto']
                    ]);
                    $resp = $this->item->create($req);
                }
            }
        }//  FIN APARTADO SUBCONTRATO

        //  INICIA APARTADO DE GENERAR ESTIMACION
        $reques_estimacion = new Request();
        $items_estimacion=[];
        $moneda = Moneda::where('tipo', 1)->first();
        //dd($contrato_proyectado['id_transaccion']);
        foreach ($partidas_conciliacion as $key => $partida) {
            $item = Item::join('Acarreos.material', 'items.id_concepto', '=', 'Acarreos.material.id_concepto_contrato')
                ->where('Acarreos.material.id_transaccion', '=', $contrato_proyectado['id_transaccion'])
                ->where('Acarreos.material.id_material_acarreo', '=', (int)$partida['id_material'])
                ->where('items.precio_unitario', '=', $partida['tarifa'])
                ->select(['items.id_item', 'items.id_concepto'])->first();

            $items_estimacion[$key] = array(
                'item_antecedente' => $item->id_concepto,
                'cantidad' => $partida['volumen']
            );
        }

        $reques_estimacion->merge([
            'id_antecedente' => $subcontrato->id_transaccion,
            'fecha' => Carbon::now()->toDateString(),
            'id_empresa' => $empresa->id_empresa,
            'id_moneda' => array_key_exists('id_moneda', $partida)? (int)$partida['id_moneda']:(int)$moneda->id_moneda,
            'cumplimiento' => Carbon::now()->toDateString(),
            'vencimiento' => Carbon::now()->addYear(1)->toDateString(),
            'referencia' => 'Estimación de Acarreos',
            'items' => ($items_estimacion)
        ]);
        //dd($reques_estimacion->all());
        $registro_estimacion = $this->estimacion->create($reques_estimacion);

        dd('pandita final');
    }

    public function getNivel($id){
        $contratos = $this->contrato->nivelPadre($id)->get();
        $val = ($contratos[count($contratos)-1]['nivel'])+1;
        if($val < 10) $nivel = '00'.$val.'.';
        if($val > 10 && $val < 100) $nivel = '0'.$val.'.';
        if($val > 100) $nivel = $val.'.';
        return $nivel;
    }
}