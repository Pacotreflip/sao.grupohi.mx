<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ItemRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class ItemController extends Controller
{
    use Helpers;

    protected $item;

    /**
     * ItemController constructor.
     * @param ItemRepository $item
     */
    public function __construct(ItemRepository $item)
    {
        parent::__construct();

        //$this->middleware('auth');
        //$this->middleware('context');

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
}
