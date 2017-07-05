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

        $this->middleware('auth');
        $this->middleware('context');

        $this->item = $item;
    }
}
