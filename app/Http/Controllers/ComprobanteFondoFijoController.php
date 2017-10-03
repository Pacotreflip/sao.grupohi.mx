<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Core\Models\Material;
use Ghi\Domain\Core\Models\Finanzas\ComprobanteFondoFijo;
use Ghi\Domain\Core\Repositories\EloquentFondoRepository;
use Ghi\Domain\Core\Repositories\EloquentItemRepository;
use Ghi\Domain\Core\Repositories\EloquentMaterialRepository;
use Ghi\Domain\Core\Transformers\ItemComprobanteFondoFijo;
use Illuminate\Http\Request;
use Ghi\Domain\Core\Contracts\Finanzas\ComprobanteFondoFijoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ComprobanteFondoFijoController extends Controller
{

    use Helpers;
    protected $comprobante_fondo_fijo;
    protected $eloquentFondoRepository;
    protected $materiales;
    protected $items;

    /**
     * ComprobanteFondoFijoController constructor.
     */
    public function __construct(ComprobanteFondoFijoRepository $comprobante_fondo_fijo, EloquentFondoRepository $eloquentFondoRepository, EloquentMaterialRepository $materiales, EloquentItemRepository $items)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');
        $this->middleware('permission:consultar_comprobante_fondo_fijo', ['only' => ['index', 'show']]);
        $this->middleware('permission:editar_comprobante_fondo_fijo', ['only' => ['edit', 'update']]);
        $this->middleware('permission:registrar_comprobante_fondo_fijo', ['only' => ['create', 'store']]);
        $this->middleware('permission:eliminar_comprobante_fondo_fijo', ['only' => ['destroy']]);


        $this->comprobante_fondo_fijo = $comprobante_fondo_fijo;
        $this->eloquentFondoRepository = $eloquentFondoRepository;
        $this->materiales = $materiales;
        $this->items = $items;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->comprobante_fondo_fijo->all();

        return view("finanzas.comprobante_fondo_fijo.index")
            ->with("comprobantes_fondo_fijo", $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fondos = $this->eloquentFondoRepository->lists();
        $materiales = $this->materiales->scope("materiales")->all();

        return view("finanzas.comprobante_fondo_fijo.create")
            ->with("fondos", $fondos)
            ->with("materiales", $materiales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if (!isset($data['items'])) {
            throw new HttpResponseException(new Response('Capture por lo menos un item.', 404));
        }

        try {
            DB::connection('cadeco')->beginTransaction();


            $comprobante_fondo_fijo = $data['comprobante'];
            $dataInsert = [
                "id_referente" => $comprobante_fondo_fijo["id_referente"],
                "referencia" => $comprobante_fondo_fijo["referencia"],
                "cumplimiento" => $comprobante_fondo_fijo["cumplimiento"],
                "fecha" => $comprobante_fondo_fijo["fecha"],
                "id_concepto" => $comprobante_fondo_fijo["id_concepto"],
                "impuesto" => $data['iva'],
                "monto" => $data['total'],
                "id_moneda" => 1,
                "observaciones" => $comprobante_fondo_fijo['observaciones']
            ];
            $comprobante = $this->comprobante_fondo_fijo->create($dataInsert);
            $items = $data['items'];
            foreach ($items as $item) {


                $dataInsertItem = [
                    "id_transaccion" => $comprobante->id_transaccion,
                    "cantidad" => $item['cantidad'],
                    "precio_unitario" => $item['precio_unitario'],
                    "estado" => 0,
                ];

                if ($item['tipo_concepto'] == 'almacen') {

                    $dataInsertItem['id_almacen'] = $item['id_concepto'];
                } else {
                    $dataInsertItem['id_concepto'] = $item['id_concepto'];
                }

                if ($comprobante_fondo_fijo["id_naturaleza"] == 0) {
                    //Gastos varios
                    $dataInsertItem["importe"] = $item['importe'];
                    $dataInsertItem["referencia"] = $item['gastos_varios'];
                } else {
                    $material = Material::find($item['id_material']);
                    $dataInsertItem["id_material"] = $material->id_material;
                    $dataInsertItem["unidad"] = $material->unidad;
                    $dataInsertItem["importe"] = ($item['precio_unitario'] * $item['cantidad']);
                }

                \Ghi\Domain\Core\Models\Transacciones\Item::create($dataInsertItem);

            }


            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }


        return response()->json(['data' => ['comprobante' => $comprobante]], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comprobante = $this->comprobante_fondo_fijo->find($id);
        $items = $this->items->with(['material', 'concepto'])->getBy('id_transaccion', '=', $comprobante->id_transaccion);

        return view("finanzas.comprobante_fondo_fijo.show")
            ->with("comprobante_fondo_fijo", $comprobante)
            ->with("items", $items);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $array = [
            "id_transaccion",
            "id_referente",
            "tipo_transaccion",
            "numero_folio",
            "fecha",
            "id_obra",
            "id_concepto",
            "cumplimiento",
            "opciones",
            "monto",
            "referencia",
            "comentario",
            "observaciones",
            "impuesto"
        ];
        $comprobante = $this->comprobante_fondo_fijo->with('concepto')->columns($array)->find($id);
        $items = $this->items->with(['material', 'concepto'])->getBy('id_transaccion', '=', $comprobante->id_transaccion);
        $items = collect(ItemComprobanteFondoFijo::transform($items));

        $fondos = $this->eloquentFondoRepository->lists();
        $materiales = $this->materiales->scope("materiales")->all();
        $comprobante['id_naturaleza'] = $comprobante->Naturaleza;

        return view("finanzas.comprobante_fondo_fijo.edit")
            ->with("comprobante_fondo_fijo", $comprobante)
            ->with("fondos", $fondos)
            ->with("materiales", $materiales)
            ->with("items", $items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        if (!isset($data['items'])) {
            throw new HttpResponseException(new Response('Capture por lo menos un item.', 404));
        }
        try {
            DB::connection('cadeco')->beginTransaction();

            $items = $data['items'];

            $comprobante_fondo_fijo = $data['comprobante'];
            $dataInsert = [
                "id_referente" => $comprobante_fondo_fijo["id_referente"],
                "referencia" => $comprobante_fondo_fijo["referencia"],
                "cumplimiento" => $comprobante_fondo_fijo["cumplimiento"],
                "fecha" => $comprobante_fondo_fijo["fecha"],
                "id_concepto" => $comprobante_fondo_fijo["id_concepto"],
                "impuesto" => $data['iva'],
                "monto" => $data['total'],
                "observaciones" => $comprobante_fondo_fijo['observaciones']
            ];
            $comprobante = $this->comprobante_fondo_fijo->update($dataInsert, $id);
            foreach ($items as $item) {


                if (isset($item['id_item'])) {
                    //update
                    $dataInsertItem = [
                        "id_transaccion" => $comprobante->id_transaccion,
                        "cantidad" => $item['cantidad'],
                        "precio_unitario" => $item['precio_unitario'],
                        "importe" => ($item['precio_unitario'] * $item['cantidad'])
                    ];

                    if ($item['tipo_concepto'] == 'almacen') {

                        $dataInsertItem['id_almacen'] = $item['id_concepto'];
                        $dataInsertItem['id_concepto'] = NULL;
                    } else {
                        $dataInsertItem['id_concepto'] = $item['id_concepto'];
                        $dataInsertItem['id_almacen'] = NULL;
                    }


                    if ($comprobante_fondo_fijo["id_naturaleza"] == 0) {
                        //Gastos varios
                        $dataInsertItem["referencia"] = $item['gastos_varios'];
                        $dataInsertItem["id_material"] = NULL;
                        $dataInsertItem["unidad"] = NULL;
                        $dataInsertItem["importe"] = $item['importe'];
                    } else {
                        $material = Material::find($item['id_material']);
                        $dataInsertItem["referencia"] = NULL;
                        $dataInsertItem["id_material"] = $material->id_material;
                        $dataInsertItem["unidad"] = $material->unidad;
                        $dataInsertItem["importe"] = ($item['precio_unitario'] * $item['cantidad']);
                    }

                    $item_update = \Ghi\Domain\Core\Models\Transacciones\Item::find($item['id_item']);
                    $item_update->update($dataInsertItem);
                } else {
                    //create

                    $dataInsertItem = [
                        "id_transaccion" => $comprobante->id_transaccion,
                        "cantidad" => $item['cantidad'],
                        "precio_unitario" => $item['precio_unitario'],
                        "importe" => ($item['precio_unitario'] * $item['cantidad']),
                    ];

                    if ($item['tipo_concepto'] == 'almacen') {

                        $dataInsertItem['id_almacen'] = $item['id_concepto'];

                    } else {
                        $dataInsertItem['id_concepto'] = $item['id_concepto'];
                    }

                    if ($comprobante_fondo_fijo["id_naturaleza"] == 0) {
                        //Gastos varios
                        $dataInsertItem["referencia"] = $item['gastos_varios'];
                    } else {
                        $material = Material::find($item['id_material']);
                        $dataInsertItem["id_material"] = $material->id_material;
                        $dataInsertItem["unidad"] = $material->unidad;
                    }


                    \Ghi\Domain\Core\Models\Transacciones\Item::create($dataInsertItem);
                }
            }
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {

            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return response()->json(['data' => ['comprobante' => $comprobante_fondo_fijo]], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->comprobante_fondo_fijo->delete($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
