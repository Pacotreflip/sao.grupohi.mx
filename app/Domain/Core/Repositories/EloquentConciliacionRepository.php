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
use Ghi\Core\Facades\Context;
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
use Ghi\Domain\Core\Models\Acarreos\EmpresaSubcontrato;
use Ghi\Domain\Core\Models\Acarreos\MaterialAcarreo;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Acarreos\ContratoProyectadoAcarreo;
use Ghi\Domain\Core\Models\Moneda;
use Ghi\Domain\Core\Models\SubcontratosEstimaciones\Estimacion;
use Ghi\Domain\Core\Models\SubcontratosEstimaciones\Folio;
use Ghi\Domain\Core\Models\SubcontratosEstimaciones\Retencion;
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
        try{
            DB::connection('cadeco')->beginTransaction();
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

            try{
                //INICIO DE APARTADO DE CONTRATO PROYECTADO
                // si contrato proyectado no existe -> crear contrato proyectado y partidas
                $contrato_proyectado = ContratoProyectadoAcarreo::where('estatus',1)->first();
                $req = new Request();
                $contratos = [];
                foreach ($partidas_conciliacion as $key => $partida){
                    $contratos[$key] =  array(
                        'nivel' => str_pad($key, 3, '0', STR_PAD_LEFT) . '.',
                        'descripcion' => $partida['material'],
                        'unidad' => 'M3',
                        'cantidad_presupuestada' => $partida['volumen'],
                        'id_material' => (int)$partida['id_material'],
                        'tarifa' => $partida['tarifa'],
                        'tiro' => $partida['tiro'],
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
                if(!$contrato_proyectado){          //  -> crear Contrato proyectado con su contrato
                    $contrato_proy_creado = $this->contratoProyectado->create($req);
                    $contrato_proyectado = ContratoProyectadoAcarreo::create(['id_transaccion' => $contrato_proy_creado->id_transaccion, 'descripcion' => $contrato_proy_creado->referencia]);

                }else{  // si existe -> buscar contrato de cada partida

                    foreach ($partidas_conciliacion as $key => $partida) {
                        $contratos = [];
                        $contrato = Contrato::join('destinos', 'contratos.id_concepto', '=', 'destinos.id_concepto_contrato')
                            ->join('Acarreos.material', 'destinos.id_concepto_contrato', '=', 'Acarreos.material.id_concepto_contrato')
                            ->where('Acarreos.material.id_material_acarreo', '=', $partida['id_material'])
                            ->where('Acarreos.material.id_concepto', '=', (int)$partida['id_concepto'])
                            ->where('Acarreos.material.tarifa', '=', $partida['tarifa'])
                            ->where('Acarreos.material.id_item', '=', $partida['tiro'])
                            ->orderBy('nivel', 'asc')->get();


                        if (count($contrato) == 0) {  // si no existe contrato adjunto al Contrato proyectado, crearlo
                            $req = new Request();

                            $contratos[] = array(
                                'nivel' => $this->getNivel($contrato_proyectado['id_transaccion']),
                                'descripcion' => $partida['material'],
                                'unidad' => 'M3',
                                'cantidad_presupuestada' => $partida['volumen'],
                                'id_material' => (int)$partida['id_material'],
                                'tarifa' => $partida['tarifa'],
                                'tiro' => $partida['tiro'],
                                'destinos' => array([
                                    'id_concepto' => (int)$partida['id_concepto']
                                ])
                            );

                            $req->merge([
                                'contratos' => ($contratos)
                            ]);

                            $this->contratoProyectado->addContratos($req, $contrato_proyectado['id_transaccion']);

                        }
                    }
                }
                // FIN DE APARTADO DE CONTRATO PROYECTADO
            }catch(\Exception $e){
                DB::connection('cadeco')->rollback();
                throw new ResourceException('Error al generar la C.P  -  ' . $e);
            }

            // INICIO DE APARTADO DE SUBCONTRATO
            // Buscar Subcontrato, si no existe crear Subcontrato con Items


            $subcontrato_acarreo = EmpresaSubcontrato::where('id_empresa_acarreo', '=', $request->id_empresa)
                                ->where('id_sindicato_acarreo', '=', $request->id_sindicato)
                                ->where('id_tipo_tarifa', '=', $request->tipo_tarifa)->first();

            try {   //// no existe subcontrato
                if(!$subcontrato_acarreo){
                    $req = new Request();
                    $items = [];
                    foreach ($partidas_conciliacion as $key => $partida){
                        $concepto_contrato = MaterialAcarreo::select('id_concepto_contrato')
                            ->where('id_material_acarreo', '=', (int)$partida['id_material'])
                            ->where('id_concepto', '=', (int)$partida['id_concepto'])
                            ->where('Acarreos.material.tarifa', '=', $partida['tarifa'])
                            ->where('Acarreos.material.id_item', '=', $partida['tiro'])
                            ->first();

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
                        'referencia' => $this->ajustar_referencia($request->sindicato, $empresa->razon_social, $request->nombre_tarifa),
                        'items' => ($items)

                    ]);
                    $subcontrato = $this->subcontrato->create($req);
                    EmpresaSubcontrato::create([
                        'id_empresa_sao' => $empresa->id_empresa,
                        'id_empresa_acarreo' => $request->id_empresa,
                        'id_sindicato_acarreo' => $request->id_sindicato,
                        'id_tipo_tarifa' => $request->tipo_tarifa,
                        'id_subcontrato' => $subcontrato->id_transaccion]);

                }else {   // si existe
                    //      -> buscar Item
                    $subcontrato = Subcontrato::where('id_transaccion', '=', $subcontrato_acarreo->id_subcontrato)->first();

                    foreach ($partidas_conciliacion as $key => $partida) {
                        $item = Item::join('Acarreos.material', 'items.id_concepto', '=', 'Acarreos.material.id_concepto_contrato')
                            ->where('Acarreos.material.id_concepto', '=', (int)$partida['id_concepto'])
                            ->where('Acarreos.material.id_material_acarreo', '=', (int)$partida['id_material'])
                            ->where('Acarreos.material.tarifa', '=', $partida['tarifa'])
                            ->where('Acarreos.material.id_item', '=', $partida['tiro'])
                            ->where('items.id_transaccion', '=', $subcontrato->id_transaccion)
                            ->select('items.id_item')->first();
                        if ($item) {    //              si existe       -> aumentar volumen

                            $req = new Request();
                            $req->merge(['cantidad' => $partida['volumen']]);
                            $this->item->update($req, $item->id_item);

                        } else {   //              no existe       -> crearlo
                            $concepto_contrato = MaterialAcarreo::select('id_concepto_contrato')
                                ->where('id_material_acarreo', '=', (int)$partida['id_material'])
                                ->where('id_concepto', '=', (int)$partida['id_concepto'])
                                ->where('Acarreos.material.tarifa', '=', $partida['tarifa'])
                                ->where('Acarreos.material.id_item', '=', $partida['tiro'])
                                ->first();
                            $req = new Request();
                            $req->merge([
                                'id_transaccion' => $subcontrato->id_transaccion,
                                'cantidad' => $partida['volumen'],
                                'precio_unitario' => $partida['tarifa'],
                                'id_concepto' => $concepto_contrato->id_concepto_contrato
                            ]);
                            $this->item->create($req);
                        }
                    }
                }
            }catch (\Exception $e){
                DB::connection('cadeco')->rollback();
                throw new ResourceException('Error al generar la S.C.  -  ' . $e);
            }
            //  FIN APARTADO SUBCONTRATO


            try{
                //  INICIA APARTADO DE GENERAR ESTIMACION
                $reques_estimacion = new Request();
                $items_estimacion=[];
                $moneda = Moneda::where('tipo', 1)->first();
                foreach ($partidas_conciliacion as $key => $partida) {
                    $item = Item::join('Acarreos.material', 'items.id_concepto', '=', 'Acarreos.material.id_concepto_contrato')
                        ->where('Acarreos.material.id_concepto', '=', (int)$partida['id_concepto'])
                        ->where('Acarreos.material.id_material_acarreo', '=', (int)$partida['id_material'])
                        ->where('Acarreos.material.tarifa', '=', $partida['tarifa'])
                        ->where('Acarreos.material.id_item', '=', $partida['tiro'])
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
                //dd($reques_estimacion);
                $registro_estimacion = $this->estimacion->create($reques_estimacion);

                /// registrar número de folio de la estimación
                $this->numero_estimacion($registro_estimacion->id_transaccion,$registro_estimacion->id_antecedente);

                // registrar retencion si la conciliacion es un acarreo
                if($request->tipo_tarifa == 1){
                    $importe_items = $registro_estimacion->items()->sum('importe');
                    Retencion::create([
                        'id_transaccion' => $registro_estimacion->id_transaccion,
                        'id_tipo_retencion' => 1,
                        'importe' => $importe_items * 0.04,
                        'concepto' => 'RETENCION DEL 4% POR SER SERVICIO DE FLETE.'
                    ]);

                }

                // registrar la conciliación con la estimación nueva
                ConciliacionEstimacion::create(['id_conciliacion' => $request->id_conciliacion, 'id_estimacion' => $registro_estimacion->id_transaccion ]);
            }catch (\Exception $e){
                DB::connection('cadeco')->rollback();
                throw new ResourceException('Error al generar la Estimacion  -  ' . $e);
            }

            DB::connection('cadeco')->commit();
            return $this->estimacion->find($registro_estimacion->id_transaccion);

        } catch(\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw new ResourceException('Error al generar la Conciliación \n' . $e);
        }
    }

    public function numero_estimacion($id_estimacion, $id_subcontrato){
        $ultimo_folio = Folio::where('IDSubcontrato', '=', $id_subcontrato)->first();
        if($ultimo_folio){
            $ultimo_folio->UltimoFolio += 1;
            $ultimo_folio->save();

            Estimacion::create(['IDEstimacion' => $id_estimacion , 'NumeroFolioConsecutivo' => $ultimo_folio->UltimoFolio ]);
        }else{
            Folio::create(['IDObra' => Context::getId(), 'IDSubcontrato' => $id_subcontrato, 'UltimoFolio' => 1]);
            Estimacion::create(['IDEstimacion' => $id_estimacion , 'NumeroFolioConsecutivo' => 1 ]);
        }
    }

    public function getNivel($id){
        $contratos = $this->contrato->nivelPadre($id)->get();
        return str_pad($contratos->count() + 1, 3, '0', STR_PAD_LEFT) . '.';
    }

    public function ajustar_referencia($sindicato, $empresa, $tarifa){
        $ref_size = (strlen($sindicato) + strlen($empresa) + 3) - 61;
        if($ref_size > 0){
            return $sindicato.'/'.substr($empresa, 0, strlen($empresa) - $ref_size).'/'.substr($tarifa, 0, 3);
        }
        return $sindicato.'/'.$empresa.'/'.substr($tarifa, 0, 3);
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
            $subcontrato_acarreo = EmpresaSubcontrato::where('id_empresa_acarreo', '=', $request->id_empresa)
                ->where('id_sindicato_acarreo', '=', $request->id_sindicato)
                ->where('id_tipo_tarifa', '=', $request->id_tarifa)->first();

            if($subcontrato_acarreo){
                $subcontrato = Subcontrato::where('id_transaccion', '=', $subcontrato_acarreo->id_subcontrato)->first();
                if($subcontrato['id_costo']){
                    return [];
                }
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
                $item = Item::where('id_concepto', '=', $concepto->item_antecedente)->where('id_transaccion', '=', $concepto->id_antecedente)->first();
                $item->cantidad -= $concepto->cantidad;
                $item->save();

                $contrato = Contrato::find($concepto->item_antecedente);
                $contrato->cantidad_presupuestada -= $concepto->cantidad;
                //$contrato->cantidad_original -= $concepto->cantidad;
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