<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ItemRepository;
use Ghi\Domain\Core\Contracts\MaterialRepository;
use Ghi\Domain\Core\Models\Material;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class ItemController extends Controller
{
    use Helpers;

    /**
     * @var MaterialRepository
     */
    private $material;
    protected $item;

    /**
     * ItemController constructor.
     * @param ItemRepository $item
     */
    public function __construct(ItemRepository $item,MaterialRepository $material)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');
        $this->material = $material;
        $this->item = $item;
    }

    public function store(Request $request) {
        $item = $this->item->create($request->all());

        return response()->json(['data' => ['item' => $item]], 200);
    }

    public function update(Request $request, $id) {
        $item = $this->item->update($request->all(), $id);

        return response()->json(['data' => ['item' => $item]], 200);
    }

    public function destroy($id) {
        $this->item->delete($id);
        return $this->response->accepted();
    }

    public function show($id)
    {
        $material = $this->material->scope('ConTransaccionES')->find($id);
        $items=$this->item->scope('conTransaccionES')->with('transaccion')->getBy('id_material', '=', $id);
        $padre=Material::find($material->id_padre);
        return response()->json(['data' => ['items' => $items,'material'=>$material,'padre'=>$padre]], 200);
    }
}
