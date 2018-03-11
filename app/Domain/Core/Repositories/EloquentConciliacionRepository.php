<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 01/12/2017
 * Time: 01:55 PM
 */

namespace Ghi\Domain\Core\Repositories;

use Carbon\Carbon;
use Dingo\Api\Exception\ResourceException;
use Ghi\Domain\Core\Contracts\ConciliacionRepository;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Contracts\ContratoProyectadoRepository;
use Ghi\Domain\Core\Contracts\ContratoRepository;
use Ghi\Domain\Core\Contracts\de;
use Ghi\Domain\Core\Contracts\EmpresaRepository;
use Ghi\Domain\Core\Contracts\EstimacionRepository;
use Ghi\Domain\Core\Contracts\ItemRepository;
use Ghi\Domain\Core\Contracts\SubcontratoRepository;
use Ghi\Domain\Core\Models\Acarreos\ConciliacionEstimacion;
use Ghi\Domain\Core\Models\Acarreos\MaterialAcarreo;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Acarreos\ContratoProyectadoAcarreo;
use Ghi\Domain\Core\Models\Moneda;
use Ghi\Domain\Core\Models\Transacciones\Item;
use Ghi\Domain\Core\Models\Transacciones\Subcontrato;
use Ghi\Domain\Core\Models\Costo;
//use GuzzleHttp\Client;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
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

        $est = ConciliacionEstimacion::where('id_conciliacion', '=', $request->id_conciliacion)->first();
        if($est){
            throw new ResourceException('La Conciliacion ya Existe en SAO');
        }

        $partidas_conciliacion = $request->get('partidas_conciliacion');
        $empresa = Empresa::where('rfc', '=', $request->rfc)->first();

        if(!$empresa){
            // si no existe -> crear empresa
            $empresa = $this->empresa->create($request->all());
        }

        //INICIO DE APARTADO DE CONTRATO PROYECTADO
        // si contrato proyectado no existe -> crear contrato proyectado y partidas
        $contrato_proyectado = ContratoProyectadoAcarreo::where('estatus',1)->first();
        if(!$contrato_proyectado){
            //  -> crear Contrato proyectado con su contrato
            $req = new Request();
            $contratos = [];
            foreach ($partidas_conciliacion as $key => $partida){
                if($key<10)$llave = '00'.$key.'.';
                if($key>9 && $key<100)$llave = '0'.$key.'.';
                if($key>100)$llave = $key.'.';
                $contratos[$key] =  array(
                    'nivel' => $llave,
                    'descripcion' => 'Acarreo de '.$partida['material'],
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
                    ->where('Acarreos.material.id_concepto', '=', (int)$partida['id_concepto'])
                    ->where('Acarreos.material.tarifa', '=', $partida['tarifa'])
                    ->orderBy('nivel', 'asc')->get();

                if (count($contrato) == 0) {  // si no existe contrato adjunto al Contrato proyectado, crearlo

                    $req = new Request();
                    $contratos = [];
                    $contratos[] =  array(
                        'nivel' => $this->getNivel($contrato_proyectado['id_transaccion']),
                        'descripcion' => 'Acarreo de '.$partida['material'],
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

                    $new = $this->contratoProyectado->addContratos($req,$contrato_proyectado['id_transaccion']);

                    $newMaterial = MaterialAcarreo::firstOrCreate([
                        'id_material_acarreo' => (int)$partida['id_material']
                        ,'id_concepto' => (int)$partida['id_concepto']
                        ,'id_concepto_contrato' => $new[0]['id_concepto']
                        ,'id_transaccion' => $contrato_proyectado['id_transaccion']
                        ,'tarifa' => $partida['tarifa']
                    ]);
                }
            }
        }  // FIN DE APARTADO DE CONTRATO PROYECTADO

        // INICIO DE APARTADO DE SUBCONTRATO
        // Buscar Subcontrato, si no existe crear Subcontrato con Items
        $subcontrato = Subcontrato::where('id_antecedente', '=', $contrato_proyectado['id_transaccion'])->where('id_empresa', '=', $empresa->id_empresa)->first();
        if(!$subcontrato){
            $req = new Request();
            $items = [];
            foreach ($partidas_conciliacion as $key => $partida){
                $concepto_contrato = MaterialAcarreo::select('id_concepto_contrato')->where('id_material_acarreo', '=',(int)$partida['id_material'])
                    ->where('id_concepto', '=',(int)$partida['id_concepto'] )->first();
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
                'referencia' => 'Subcontrato '. $empresa->razon_social ,
                'items' => ($items)

            ]);
            $subcontrato = $this->subcontrato->create($req);

        }else {   // si existe
            //      -> buscar Item
            foreach ($partidas_conciliacion as $key => $partida) {
                $item = Item::join('Acarreos.material', 'items.id_concepto', '=', 'Acarreos.material.id_concepto_contrato')
                    ->where('Acarreos.material.id_concepto', '=', (int)$partida['id_concepto'])
                    ->where('Acarreos.material.id_material_acarreo', '=', (int)$partida['id_material'])
                    ->where('Acarreos.material.tarifa', '=', $partida['tarifa'])
                    ->where('items.id_transaccion', '=', $subcontrato->id_transaccion)
                    ->select('items.id_item')->first();
                if ($item) {    //              si existe       -> aumentar volumen

                    $req = new Request();
                    $req->merge(['cantidad' => $partida['volumen']]);
                    $resp = $this->item->update($req, $item->id_item);

                } else {   //              no existe       -> crearlo
                    $concepto_contrato = MaterialAcarreo::select('id_concepto_contrato')->where('id_material_acarreo', '=',(int)$partida['id_material'])
                        ->where('id_concepto', '=',(int)$partida['id_concepto'] )
                        ->where('Acarreos.material.tarifa', '=', $partida['tarifa'])->first();
                    $req = new Request();
                    $req->merge([
                        'id_transaccion' => $subcontrato->id_transaccion,
                        'cantidad' => $partida['volumen'],
                        'precio_unitario' => $partida['tarifa'],
                        'id_concepto' => $concepto_contrato->id_concepto_contrato
                    ]);
                    $resp = $this->item->create($req);
                }
            }
        }//  FIN APARTADO SUBCONTRATO

        //  INICIA APARTADO DE GENERAR ESTIMACION
        $reques_estimacion = new Request();
        $items_estimacion=[];
        $moneda = Moneda::where('tipo', 1)->first();
        foreach ($partidas_conciliacion as $key => $partida) {
            $item = Item::join('Acarreos.material', 'items.id_concepto', '=', 'Acarreos.material.id_concepto_contrato')
                ->where('Acarreos.material.id_concepto', '=', (int)$partida['id_concepto'])
                ->where('Acarreos.material.id_material_acarreo', '=', (int)$partida['id_material'])
                ->where('Acarreos.material.tarifa', '=', $partida['tarifa'])
                ->where('items.id_transaccion', '=', $subcontrato->id_transaccion)
                ->select(['items.id_item', 'items.id_concepto'])->first();
            $items_estimacion[$key] = array(
                'item_antecedente' => $item['id_concepto'],
                'cantidad' => $partida['volumen']
            );
        }

        $reques_estimacion->merge([
            'id_antecedente' => $subcontrato->id_transaccion,
            'fecha' => Carbon::now()->toDateString(),
            'id_empresa' => $empresa->id_empresa,
            'id_moneda' => array_key_exists('id_moneda', $partida)? (int)$partida['id_moneda']:(int)$moneda->id_moneda,
            'cumplimiento' => Carbon::parse($request->cumplimiento)->toDateString(),
            'vencimiento' => Carbon::parse($request->vencimiento )->toDateString(),
            'referencia' => 'Estimación de Acarreos ' . Carbon::now()->toDateTimeString(),
            'observaciones' => 'Conciliación con Folio ' . $request->id_conciliacion . ' de Sistema de Acarreos',
            'items' => ($items_estimacion)
        ]);
        $registro_estimacion = $this->estimacion->create($reques_estimacion);

        ConciliacionEstimacion::create(['id_conciliacion' => $request->id_conciliacion, 'id_estimacion' => $registro_estimacion->id_transaccion ]);

        return $this->estimacion->find($registro_estimacion->id_transaccion);
    }

    public function getNivel($id){
        $nivel = '';
        $contratos = $this->contrato->nivelPadre($id)->get();
        $val = (int)($contratos[count($contratos)-1]['nivel'])+1;
        if($val < 10) $nivel = '00'.$val.'.';
        if($val >= 10 && $val < 100) $nivel = '0'.$val.'.';
        if($val > 99) $nivel = $val.'.';
        return $nivel;
    }

    /**
     * Recupera los Costos de la pista en caso de que no exista un Costo
     * asociado a la empresa en el subcontrato.
     * @param Request $request
     * @return mixed
     */
    public function getCostos(Request $request)
    {
        $contrato_proyectado = ContratoProyectadoAcarreo::where('estatus',1)->first();
        $empresa = Empresa::where('rfc', '=', $request->rfc)->first();
        if($contrato_proyectado && $empresa) {
            $subcontrato = Subcontrato::where('id_antecedente', '=', $contrato_proyectado->id_transaccion)->where('id_empresa', '=', $empresa->id_empresa)->first();
            if($subcontrato['id_costo']){
                return [];
            }
        }
        $costos = Costo::select(['id_costo', 'descripcion'])->get()->toArray();
        return $costos;
    }

    /**
     * Elimina una Estimación
     * @param $id de la Estimación
     * @return mixed
     * @throws \Exception
     */
    public function delete($id)
    {
        $conciliacion = ConciliacionEstimacion::where('id_conciliacion', '=', $id)->first();
        if(!$conciliacion){
            throw new ResourceException('2:La Conciliacion No tiene Estimación Registrada en SAO.');
        }

        $pagos_asociados = $this->validarAfectacionPagos($conciliacion->id_estimacion); //  = Item::where('id_antecedente', '=', )->first();
        if(strlen($pagos_asociados) > 1){
            throw new ResourceException($pagos_asociados);
        }
        $estimacion = $this->estimacion->find($conciliacion->id_estimacion);
        $conceptos = Item::where('id_transaccion', '=', $estimacion->id_transaccion)->get();


        try {
            DB::connection('cadeco')->beginTransaction();
            foreach ($conceptos as $concepto) {
                $item = Item::where('id_concepto', '=', $concepto->item_antecedente)->first();
                $item->cantidad -= $concepto->cantidad;
                $item->save();

                $contrato = Contrato::find($concepto->item_antecedente);
                $contrato->cantidad_presupuestada -= $concepto->cantidad;
                $contrato->cantidad_original -= $concepto->cantidad;
                $contrato->save();
            }
            $registro_conciliacion = ConciliacionEstimacion::where('id_estimacion', '=', $conciliacion->id_estimacion)->first();
            $registro_conciliacion->delete();

            $estimacion->delete();
            $conciliacion->delete();

            DB::connection('cadeco')->commit();
        }catch (\Exception $e){
            DB::connection('cadeco')->rollback();
            throw new ResourceException('No se Eliminó la Estimación de la Conciliación Seleccionada.' );
        }

        return $conceptos;
    }

    /**
     * Valida que la Estimación que se va a eliminar no cuente con registro de
     * factura, orden de pago y pago registrado
     * @param $id_estimacion
     * @return string
     */
    public function validarAfectacionPagos($id_estimacion){
        $mensaje = "";
        $estimacion = Transaccion::where('id_transaccion', '=', $id_estimacion)->first();
        if($estimacion->estado == 1){
            return "1:" . $estimacion->numero_folio;
        }
        $item = Item::where('id_antecedente', '=', $id_estimacion)->first();
        if($item){
            $factura = Transaccion::where('id_transaccion', '=', $item->id_transaccion)->first();
            $mensaje = $mensaje . "Factura:" . $factura->numero_folio;
            $contra_recibo = Transaccion::where('id_transaccion', '=', $factura->id_antecedente)->first();
            if($contra_recibo){
                $mensaje = $mensaje . ":Contrarecibo:" . $contra_recibo->numero_folio;
            }
            $orden_pago = Transaccion::where('id_referente', '=', $item->id_transaccion)->first();
            if($orden_pago){
                $mensaje = $mensaje . ":Orden de Pago:" . $orden_pago->numero_folio;
                $pago = Transaccion::where('numero_folio', '=', $orden_pago->numero_folio)->where('tipo_transaccion', '=', Tipo::PAGO)->first();
                if($pago){
                    $mensaje = $mensaje . ":Pago:" . $pago->numero_folio;
                }
            }
        }
        return $mensaje;
    }


}