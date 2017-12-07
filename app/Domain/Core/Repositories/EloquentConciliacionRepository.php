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
use Ghi\Domain\Core\Contracts\ItemRepository;
use Ghi\Domain\Core\Contracts\SubcontratoRepository;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Acarreos\ContratoProyectadoAcarreo;
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
     * EloquentConciliacionRepository constructor.
     * @param EmpresaRepository $empresa
     * @param ContratoProyectadoRepository $contratoProyectado
     * @param SubcontratoRepository $subcontrato
     * @param ContratoRepository $contrato
     * @param ItemRepository $item
     */
    public function __construct(EmpresaRepository $empresa, ContratoProyectadoRepository $contratoProyectado, SubcontratoRepository $subcontrato, ContratoRepository $contrato, ItemRepository $item)
    {
        $this->empresa = $empresa;
        $this->contratoProyectado = $contratoProyectado;
        $this->subcontrato = $subcontrato;
        $this->contrato = $contrato;
        $this->item = $item;
    }


    public function store(Request $request)
    {

        $partidas_conciliacion = $request->get('partidas_conciliacion');
        $empresa = Empresa::where('rfc', '=', $request->rfc)->first();

        if(!$empresa){
            //TODO crear empresa
            $empresa = $this->empresa->create($request);
        }
        // si contrato proyectado no existe

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
            $rep = ContratoProyectadoAcarreo::create(['id_transaccion' => $contrato_proy_creado->id_transaccion, 'descripcion' => $contrato_proy_creado->referencia]);

        }else{  // si existe
            //dd('Pandita existe',(int)$contrato_proyectado->id_transaccion );
            //      -> buscar contrato de cada partida

            foreach ($partidas_conciliacion as $key => $partida) {

                $contrato = Contrato::join('destinos', 'contratos.id_concepto', '=', 'destinos.id_concepto_contrato')
                    ->join('Acarreos.material', 'destinos.id_concepto_contrato', '=', 'Acarreos.material.id_concepto_contrato')
                    ->where('Acarreos.material.id_material_acarreo', '=', $partida['id_material'])
                    ->where('destinos.id_concepto', '=', (int)$partida['id_concepto'])->first();
                if (!$contrato) {

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

        }


        // si subcontrato no existe
        if(!$subcontrato = Subcontrato::where('id_antecedente', '=', 3902)->where('id_empresa', '=', 405)->get()){
            dd($subcontrato);    //      -> crear subcontrato con items
        }else{   // si existe
            //      -> buscar Item
            $item = Item::join('destinos', 'items.id_concepto', '=', 'destinos.id_concepto_contrato')
                        ->where('items.id_transaccion', '=', 29261)
                        ->where('destinos.id_concepto', '=', 18150)->get();
            if($item){    //              si existe       -> aumentar volumen

            }else{   //              no existe       -> crearlo

            }
        }

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